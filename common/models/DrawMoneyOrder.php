<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "draw_money_order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $sys_order_id
 * @property string $account_name
 * @property string $account_number
 * @property string $receipt_number
 * @property int $money
 * @property string $remark
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $success_at
 */
class DrawMoneyOrder extends \yii\db\ActiveRecord
{

    const STATUS_UNTREATED = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_SEND_BACK = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%draw_money_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sys_order_id', 'account_name', 'account_number', 'money', ], 'required'],
            [['user_id', 'money', 'status', 'created_at', 'updated_at', 'success_at'], 'integer'],
            [['sys_order_id', 'account_name', 'account_number', 'receipt_number', 'remark'], 'string', 'max' => 255],
            ['money', 'checkUserMoney'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'sys_order_id' => '系统订单号',
            'account_name' => '收款账户',
            'account_number' => '收款账号',
            'receipt_number' => '交易流水号',
            'money' => '金额',
            'remark' => '备注',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'success_at' => '完成时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * 表字段的枚举解释
     */
    public static function enumState($type = null, $field = null){
        $lsEnum =  [
            'status'=>[
                self::STATUS_UNTREATED  => '预扣',
                self::STATUS_PROCESSED  => '成功',
                self::STATUS_SEND_BACK  => '手动退回',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ?? $lsEnum[$type] ;
        }

        return $lsEnum;
    }

    /**
     * 生成订单号
     */
    public function generateSysOrderId($userId)
    {
        return $userId . date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * 检查用户的金额是否允许提款
     */
    public function checkUserMoney($attribute, $params)
    {
        $oqUser = User::findOne($this->user_id);
        if ($this->money > $oqUser->money){
            $this->addError($attribute, '金额不足');
            return false;
        }
        return true;
    }

    /**
     * 添加申请并预扣用户对应的金额
     */
    public function addApplyAndWithhold()
    {
        $transaction = Yii::$app->db->beginTransaction();
        //添加申请订单
        if ($this->save()){
            //修改用户金额并记录对应的日志
            $oqUser = User::findOne($this->user_id);
            if($oqUser->subMoney($this->money, ChangeUserMoneyLog::TYPE_DRAW_MONEY_WITHHOLD , $this->sys_order_id)){
                $transaction->commit();
                return true;
            }
        }

        $this->addError('sys', '申请失败，请联系管理员');
        $transaction->rollBack();
        return false;
    }

    /**
     * 修改申请
     */
    public function saveApply()
    {

        $transaction = Yii::$app->db->beginTransaction();

        $oqChangeUserMoneyLog = ChangeUserMoneyLog::findOne(['extra'=>$this->sys_order_id]);
        if($oqChangeUserMoneyLog === null){
            $transaction->rollBack();
            return false;
        }

        switch ($this->status){
            case self::STATUS_PROCESSED:
                $this->success_at = time();
                $oqChangeUserMoneyLog->type = ChangeUserMoneyLog::TYPE_DRAW_MONEY_SUCCESS;
                if ($oqChangeUserMoneyLog->save() && $this->save()){
                    $transaction->commit();
                    return true;
                }
                break;

            case self::STATUS_SEND_BACK:
                $oqChangeUserMoneyLog->type = ChangeUserMoneyLog::TYPE_DRAW_MONEY_WITHHOLD;
                if ($oqChangeUserMoneyLog->save() && $this->save()){
                    $oqUser = User::findOne($this->user_id);
                    if ($oqUser->addMoney($this->money, ChangeUserMoneyLog::TYPE_DRAW_MONEY_BACK , $this->sys_order_id)){
                        $transaction->commit();
                        return true;
                    }
                }

                break;
            default:
                $this->addError('status', '设置错误错误！！！');

        }
        $transaction->rollBack();
        return false;
    }
}
