<?php

namespace common\models;

use Yii;

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
 * @property int $notify_time
 * @property int $success_time
 * @property int $query_time
 */
class PayOrder extends \yii\db\ActiveRecord
{

    const STATUS_NON_PAYMENT = 0;
    const STATUS_HAVE_PAID = 1;
    const STATUS_NOTIFY_SUCCESS = 2;
    const STATUS_QUERY_SUCCESS = 3;
    const STATUS_TURN_DOWN = 4;
    const STATUS_CORRECTION = 5;

    public static function tableName()
    {
        return '{{%pay_order}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'pay_channel_id', 'user_id', 'user_account', 'pay_money', 'profit_rate', 'cost_rate', 'inform_num', 'status',  'notify_time', 'success_time', 'query_time'], 'integer'],
            [['pay_channel_code', 'pay_channel_account', 'pay_channel_account_extra', 'md5_key', 'public_key', 'private_key', 'user_id', 'user_account', 'sys_order_id', 'user_order_id', 'supplier_order_id', 'cost_rate', 'user_notify_url', 'user_callback_url', 'user_extra_field'], 'required'],
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
            'profit_money' => '利润',
            'inform_num' => '下游通知次数',
            'user_notify_url' => '用户回调Url地址',
            'user_callback_url' => '用户同步跳转Url地址',
            'user_extra_field' => '用户扩展字段',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'notify_time' => '上游回调成功时间',
            'success_time' => '下游返回成功时间',
            'query_time' => '查询上游成功时间',
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

    public function checkHaveAddMoney(){
        return in_array($this->status, $this->haveAddMoneyStatus());
    }

    protected function haveAddMoneyStatus()
    {
        return [
            self::STATUS_HAVE_PAID,
            self::STATUS_NOTIFY_SUCCESS,
            self::STATUS_QUERY_SUCCESS,
            self::STATUS_CORRECTION,
        ];
    }

    public static function enumState($type = null, $field = null){
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
            return $lsEnum[$type][$field] ? : $lsEnum[$type] ;
        }

        return $lsEnum;
    }
}
