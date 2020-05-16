<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%change_user_money_log}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $change_money
 * @property int $before_money
 * @property int $after_money
 * @property int $type
 * @property string $extra
 * @property int $created_at
 * @property int $updated_at
 */
class ChangeUserMoneyLog extends \yii\db\ActiveRecord
{

    const TYPE_PAY_ORDER_CORRECTION =   1;
    const TYPE_PAY_ORDER_TURN_DOWN  =   2;
    const TYPE_PAY_ORDER_SUCCESS    =   3;
    const TYPE_DRAW_MONEY_WITHHOLD  =   4;
    const TYPE_DRAW_MONEY_SUCCESS   =   5;
    const TYPE_DRAW_MONEY_BACK      =   6;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%change_user_money_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'change_money', 'before_money', 'after_money', 'type'], 'required'],
            [['user_id', 'change_money', 'before_money', 'after_money'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '用户id'),
            'change_money' => Yii::t('app', '改变金额'),
            'before_money' => Yii::t('app', '改变前金额'),
            'after_money' => Yii::t('app', '改变后金额'),
            'type' => Yii::t('app', '类型'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
            'extra'     => Yii::t('app', '扩展信息'),
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

    public static function enumState($type = null, $field = null){
        $lsEnum =  [
            'type'=>[
                self::TYPE_PAY_ORDER_CORRECTION => '支付订单校正',
                self::TYPE_PAY_ORDER_TURN_DOWN  => '支付订单驳回',
                self::TYPE_PAY_ORDER_SUCCESS    => '订单支付成功',
                self::TYPE_DRAW_MONEY_WITHHOLD  => '申请提款预扣',
                self::TYPE_DRAW_MONEY_SUCCESS  => '申请提款成功',
                self::TYPE_DRAW_MONEY_BACK      => '申请提款退还',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ?? $lsEnum[$type] ;
        }

        return $lsEnum;
    }

}
