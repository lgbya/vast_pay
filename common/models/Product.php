<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property string $name 支付产品名
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_del
 */
class Product extends \yii\db\ActiveRecord
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
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status', 'created_at', 'updated_at', 'is_del'], 'integer'],
            ['status', 'in', 'range'=>[self::STATUS_OFF, self::STATUS_ON]],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '产品名',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更改时间',
            'is_del' => 'Is Del',
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

    public function getIdToNameList($isDel = null)
    {
        $query = self::find();
        $oqlProduct = $query->select(['id','name'])->andFilterWhere(['is_del'=> $isDel])->all();

        $lsIdToName = [];
        foreach ($oqlProduct as $k => $v){
            $lsIdToName[$v->id] = $v->name;
        }

        return $lsIdToName;
    }

    public function getPayChannels($isDel = null, $status=null)
    {
        return $this->hasMany(PayChannel::className(), ['product_id' => 'id']);
    }

    public function getAllNormalProducts(){
        return self::find()
            ->andWhere(['is_del'=>Product::DEL_STATE_NO])
            ->andWhere(['status'=>Product::STATUS_ON])
            ->all();
    }

    public static function enumState($type = null, $field = null)
    {
        $lsEnum =  [
            'status'=>[
                self::STATUS_ON=>'开启',
                self::STATUS_OFF=>'关闭',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ? : $lsEnum[$type] ;
        }

        return $lsEnum;
    }

}
