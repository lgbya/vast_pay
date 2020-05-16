<?php

namespace common\models;

use common\helper\Sign;
use linslin\yii2\curl\Curl;
use Yii;
use common\helper\Helper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%pay_order}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $pay_channel_id
 * @property string $pay_channel_code
 * @property string $pay_channel_account
 * @property string $pay_channel_account_extra
 * @property string $md5_key
 * @property string $public_key
 * @property string $private_key
 * @property int $user_id
 * @property int $user_account
 * @property string $sys_order_id
 * @property string $user_order_id
 * @property string $supplier_order_id
 * @property int $pay_money
 * @property int $profit_rate
 * @property int $cost_rate
 * @property float $user_money
 * @property float $cost_money
 * @property float $profit_money
 * @property int $inform_num
 * @property string $user_notify_url
 * @property string $user_callback_url
 * @property string $user_extra_field
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $notify_at
 * @property int $success_at
 * @property int $query_at
 */
class PayOrder extends \yii\db\ActiveRecord
{

    const STATUS_NON_PAYMENT = 0;
    const STATUS_HAVE_PAID = 1;
    const STATUS_NOTIFY_SUCCESS = 2;
    const STATUS_QUERY_SUCCESS = 3;
    const STATUS_TURN_DOWN = 4;
    const STATUS_CORRECTION = 5;

    public $sys_notify_url;
    public $sys_callback_url;

    public static function tableName()
    {
        return '{{%pay_order}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function enumState($type = null, $field = null)
    {
        $lsEnum =  [
            'status'=>[
                self::STATUS_NON_PAYMENT    => '未支付',
                self::STATUS_HAVE_PAID      => '已支付',
                self::STATUS_NOTIFY_SUCCESS => '通知下游成功',
                self::STATUS_QUERY_SUCCESS  => '系统查询成功',
                self::STATUS_TURN_DOWN      => '手动驳回',
                self::STATUS_CORRECTION     => '手动校正',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ?? $lsEnum[$type] ;
        }

        return $lsEnum;
    }

    public function rules()
    {
        return [
            [['product_id', 'pay_channel_id', 'user_id', 'pay_money', 'profit_rate', 'cost_rate', 'inform_num', 'status',  'notify_at', 'success_at', 'query_at'], 'integer'],
            [['pay_channel_code', 'pay_channel_account', 'md5_key', 'public_key', 'private_key', 'user_id', 'user_account', 'sys_order_id', 'user_order_id', 'cost_rate', 'user_notify_url', 'user_callback_url'], 'required'],
            [['user_money', 'cost_money', 'profit_money'], 'number'],
            [['pay_channel_code', 'pay_channel_account', 'pay_channel_account_extra', 'md5_key', 'public_key', 'private_key', 'user_notify_url', 'user_callback_url', 'user_extra_field'], 'string', 'max' => 255],
            [['sys_order_id', 'user_order_id', 'supplier_order_id'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => '产品ID',
            'pay_channel_id' => '通道ID',
            'pay_channel_code' => '通道Code',
            'pay_channel_account' => '通道账号',
            'pay_channel_account_extra' => '通道账号扩展',
            'md5_key' => 'md5秘钥',
            'public_key' => '公钥',
            'private_key' => '私钥',
            'user_id' => '用户ID',
            'user_account' => '用户账号',
            'sys_order_id' => '系统订单号',
            'user_order_id' => '用户订单号',
            'supplier_order_id' => '上游订单号',
            'profit_rate' => '利润率(单位:万分之一)',
            'cost_rate' => '成本费率(单位:万分之一)',
            'pay_money' => '原金额',
            'user_money' => '用户获得',
            'cost_money' => '成本',
            'profit_money' => '收取费用',
            'inform_num' => '下游通知次数',
            'user_notify_url' => '用户回调Url地址',
            'user_callback_url' => '用户同步跳转Url地址',
            'user_extra_field' => '用户扩展字段',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'notify_at' => '上游回调成功时间',
            'success_at' => '下游返回成功时间',
            'query_at' => '查询上游成功时间',
        ];
    }

    public function getPayChannel()
    {
        return $this->hasOne(PayChannel::className(), ['id'=>'pay_channel_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id'=>'product_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    /**
     * 检查订单是否已加钱
     */
    public function checkHaveAddMoney(){
        return in_array($this->status, $this->userHavePayMoneyStatus());
    }

    /**
     * 用户已支付的订单状态列表
     */
    public function userHavePayMoneyStatus()
    {
        return [
            self::STATUS_HAVE_PAID,
            self::STATUS_NOTIFY_SUCCESS,
            self::STATUS_QUERY_SUCCESS,
            self::STATUS_CORRECTION,
        ];
    }

    /**
     * 生成支付订单
     */
    public  function generateOrder($oqUser, $ofPayment, $lChannel, $lAccount)
    {
        $this->sys_order_id = $this->generateSysOrderId($oqUser->id);
        $this->user_order_id = $ofPayment->order_id;
        $this->product_id = $lChannel['product_id'];
        $this->pay_channel_id = $lChannel['id'];
        $this->pay_channel_code = $lChannel['code'];
        $this->cost_rate = $lChannel['cost_rate'];
        $this->profit_rate = $lChannel['profit_rate'];
        $this->pay_channel_account = $lAccount['account'];
        $this->pay_channel_account_extra = $lAccount['extra'];
        $this->md5_key = $lAccount['md5_key'];
        $this->public_key = $lAccount['public_key'];
        $this->private_key = $lAccount['private_key'];

        $this->user_id = $oqUser->id;
        $this->user_account = $oqUser->account;
        $this->user_extra_field = $ofPayment->extra;
        $this->user_notify_url = $ofPayment->notify_url;
        $this->user_callback_url = $ofPayment->callback_url;
        $this->user_sign_type = $ofPayment->sign_type;

        $this->pay_money = $ofPayment->money;
        $this->cost_money = $this->countCostMoney($ofPayment->money, $lChannel['cost_rate']);
        $this->profit_money = $this->countProfitMoney($ofPayment->money, $lChannel['profit_rate']);
        $this->user_money = $this->countUserMoney($this->pay_money, $this->profit_money);

        $this->status = PayOrder::STATUS_NON_PAYMENT;
        if ($this->save()){

            $hostInfo = Yii::$app->request->hostInfo;
            $this->sys_notify_url = $hostInfo . '/payment/notify/'. $this->sys_order_id ;
            $this->sys_callback_url = $hostInfo . '/payment/callback/'. $this->sys_order_id;

            return $this;
        }

        return false;
    }

    /**
     * 计算成本
     */
    public function countCostMoney($money, $costRate)
    {
        return bcmul($money, $costRate/1000, 3);
    }

    /**
     * 计算利润
     */
    public function countProfitMoney($money, $profitRate)
    {
        return bcmul($money, $profitRate/1000, 3);
    }

    /**
     * 计算用户获得
     */
    public function countUserMoney($payMoney, $profitMoney)
    {
        return bcsub($payMoney, $profitMoney, 3);

    }

    /**
     * 生成订单号
     */
    public function generateSysOrderId($userId)
    {
        return $userId . date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * 回调通知用户
     */
    public function notifyUser($userSignType = null)
    {
        $ocCurl = new Curl();
        $params = $this->notifyUserParams($userSignType);
        $response = $ocCurl->setPostParams($params)->post($this->user_notify_url);
        if ($ocCurl->responseCode == '200' && $response == 'SUCCESS'){
            $this->status = PayOrder::STATUS_NOTIFY_SUCCESS;
            $this->success_at = time();
            $this->inform_num += 1;
            if(!$this->save()){
                Yii::warning(['message' =>'通知下游成功，订单修改状态失败！！！', 'sys_order_id' => $this->sys_order_id ,'errors'=> $oqPayOrder->errors]);
            }
        }
    }

    /**
     * 同步通知用户
     */
    public function callbackUser($userSignType = null)
    {
        $params = $this->notifyUserParams($userSignType);
        $params['sign'] = (new PaymentForm())->sign($params, $this->user, $userSignType);
        return Helper::createForm($this->user_callback_url, $params);
    }

    /**
     * 通知用户的基本公共参数
     */
    public function notifyUserParams($userSignType = null)
    {
        $params = [
            'account' => $this->user_account,
            'sys_order_id' => $this->sys_order_id,
            'user_order_id' => $this->user_order_id,
            'money' => $this->pay_money,
            'extra' => $this->user_extra_field,
            'create_at'=> $this->created_at,
            'success_at'=>$this->notify_at,
            'status' => $this->checkHaveAddMoney()?'1':'0',
        ];
        $userSignType = isset($userSignType) ? $userSignType : $this->user_sign_type;
        $params['sign'] = (new Sign($userSignType))->encrypt($params, $this->user);
        return $params;
    }

    /**
     * 查询用户的用户订单号对应的订单
     */
    public static function findByUserOrder($userId, $userOrderId)
    {
        return self::findOne(['user_id'=>$userId, 'user_order_id' => $userOrderId]);
    }

    /**
     * 查询系统订单号对应的订单
     */
    public static function findBySysOrderId($sysOrderId)
    {
        return self::find()->with(User::TABLE_NAME)->andFilterWhere(['sys_order_id'=>$sysOrderId])->one();
    }


}
