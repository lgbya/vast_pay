<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_to_pay_channel}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $pay_channel_id
 * @property int $created_at
 * @property int $updated_at
 */
class UserToPayChannel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_to_pay_channel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'pay_channel_id'], 'required'],
            [['user_id', 'pay_channel_id', 'created_at', 'updated_at'], 'integer'],
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
            'pay_channel_id' => '支付通道id',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }



    public function getPayChannel()
    {
        return $this->hasOne(PayChannel::className(), ['id'=>'pay_channel_id']);
    }

    public function getUserProductChannelIds($userId)
    {
        $oqlUserPayChannel = self::find()->andFilterWhere(['user_id'=>$userId])->all();
        $lsChannelIds = [];
        foreach ($oqlUserPayChannel as $k => $v){
            $lsChannelIds[$v->payChannel->product_id][] = $v->payChannel->id;
        }
        return $lsChannelIds;
    }

    public function insertUserPayChannels($userId = 0, $lPayChannelId = []){
        if ($lPayChannelId == [] || $userId <= 0){
            $this->addError('pay_channel_id','支付产品分配失败！请选择支付产品');
            return false;
        }
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $result = $db->createCommand()
                ->delete(UserToPayChannel::tableName(),'user_id=:user_id', [':user_id'=>$userId])
                ->execute();

            if ($result === false){
                $this->addError('pay_channel_id','支付产品重新分配失败！请联系管理员！');
                $transaction->rollBack();
                return false;
            }

            $lsData = [];
            foreach($lPayChannelId as $k => $v){
                $lsData[] = [
                    'user_id'=> $userId,
                    'pay_channel_id' => $v,
                    'created_at'=>time(),
                    'updated_at'=>time(),
                ];
            }
            $lField = ['user_id', 'pay_channel_id', 'created_at', 'updated_at' ];
            $result = $db->createCommand()
                ->batchInsert(UserToPayChannel::tableName(), $lField, $lsData)
                ->execute();
            if ($result === false){
                $this->addError('pay_channel_id','支付产品分配失败！请联系管理员');
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            Yii::error($e);
            $transaction->rollBack();
            $this->addError('pay_channel_id','系统错误！请联系管理员');
            return false;
        }

    }
}
