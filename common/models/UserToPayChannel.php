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


    public function getNormalProductToChannelIds($userId )
    {

        $oqlUserToPayChannel = $this->getNormalUserChannels($userId);
        $lsChannelIds = [];
        foreach ($oqlUserToPayChannel as $k => $v){
            $lsChannelIds[$v['product_id']][] = $v['id'];
        }
        return $lsChannelIds;
    }

    public function getNormalUserChannels($userId )
    {

        $payChannelTableName = PayChannel::tableName();
        return UserToPayChannel::find()
            ->alias('u')
            ->select('c.*')
            ->leftJoin( "{$payChannelTableName} c", 'c.id = u.pay_channel_id ')
            ->andWhere(['u.user_id'=>$userId])
            ->andWhere(['c.status'=>PayChannel::STATUS_ON])
            ->andWhere(['c.is_del'=>PayChannel::DEL_STATE_NO])
            ->asArray()
            ->all();
    }

    public function insertUserPayChannels($userId = 0, $lPayChannelId = []){

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
            if ($lPayChannelId !== [] ){
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
            }else{
                $transaction->commit();
                return true;
            }

        } catch(\Exception $e) {
            Yii::error($e);
            $transaction->rollBack();
            $this->addError('pay_channel_id','系统错误！请联系管理员');
            return false;
        }

    }
}
