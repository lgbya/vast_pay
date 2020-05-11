<?php

namespace common\models;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'draw_money_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sys_order_id', 'account_name', 'account_number', 'receipt_number', 'money', 'remark', 'success_at'], 'required'],
            [['user_id', 'money', 'status', 'created_at', 'updated_at', 'success_at'], 'integer'],
            [['sys_order_id', 'account_name', 'account_number', 'receipt_number', 'remark'], 'string', 'max' => 255],
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
            'account_name' => '账户',
            'account_number' => '账号',
            'receipt_number' => '交易流水号',
            'money' => '金额',
            'remark' => '备注',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'success_at' => '完成时间',
        ];
    }
}
