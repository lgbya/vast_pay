<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%pay_channel}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $code
 * @property int $profit_rate 收取费率，单位:万分之一
 * @property int $cost_rate 成本费率，单位:万分之一
 * @property int $weight 权重
 * @property string $request_url 请求url
 * @property int $status 状态:1-开启,0-关闭
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_del
 */
class PayChannel extends \yii\db\ActiveRecord
{

    const TABLE_NAME = 'pay_channel';

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    const DEL_STATE_NO = 0; //删除状态no
    const DEL_STATE_YES = 1; //删除状态yes

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%' . self::TABLE_NAME . '}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'name', 'code', 'cost_rate','profit_rate', 'request_url'], 'required'],
            ['code','unique'],
            [['product_id', 'profit_rate', 'cost_rate', 'weight', 'status', 'is_del'], 'integer'],
            ['status', 'in', 'range'=>[self::STATUS_OFF, self::STATUS_ON]],
            ['request_url', 'url', 'defaultScheme' => 'http'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => '产品类型',
            'name' => '通道名称',
            'code' => '通道Code',
            'profit_rate' => '收取费率(单位:千分之一)',
            'cost_rate' => '成本费率(单位:千分之一)',
            'weight' => '权重',
            'request_url' => '请求url',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'is_del' => '是否删除',
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

    public function getProduct()
    {
        return $this->hasOne(Product::className(),['id'=>'product_id']);
    }

    public function getIdToNameList($isDel = Null)
    {
        $oqlPayChannel = self::find()
            ->select(['id','name'])
            ->andFilterWhere(['is_del'=> $isDel])
            ->all();

        $lsIdToName = [];
        foreach ($oqlPayChannel as $k => $v){
            $lsIdToName[$v->id] = $v->name;
        }

        return $lsIdToName;
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
            return $lsEnum[$type][$field] ?? $lsEnum[$type] ;
        }

        return $lsEnum;
    }
}
