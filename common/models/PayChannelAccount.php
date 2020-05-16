<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%pay_channel_account}}".
 *
 * @property int $id
 * @property int $pay_channel_id
 * @property string $account
 * @property string $appid
 * @property string $md5_key
 * @property string $private_key
 * @property string $public_key
 * @property int $weight
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_del
 */
class PayChannelAccount extends \yii\db\ActiveRecord
{

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    const DEL_STATE_NO = 0; //删除状态no
    const DEL_STATE_YES = 1; //删除状态yes

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pay_channel_account}}';
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pay_channel_id','account'], 'required'],
            [[ 'weight', 'created_at', 'updated_at'], 'integer'],
            ['status', 'in', 'range'=>[self::STATUS_OFF, self::STATUS_ON]],
            [['account', 'appid', 'md5_key', 'private_key', 'public_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_channel_id' => '通道类型',
            'account' => '子账号',
            'appid' => 'Appid',
            'md5_key' => 'Md5秘钥',
            'private_key' => '私钥',
            'public_key' => '公钥',
            'weight' => '权重',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'is_del' => '是否删除',
        ];
    }

    public function getPayChannel(){
        return $this->hasOne(PayChannel::className(), ['id' => 'pay_channel_id']);
    }

    public static  function enumState($type = null, $field = null){
        $lsEnum =  [
            'status'=>[
                self::STATUS_ON=>'开启',
                self::STATUS_OFF=>'关闭',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ?? $lsEnum[$type] ;
        }

        return $lsEnum;
    }

}
