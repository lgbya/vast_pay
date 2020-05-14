<?php

namespace common\models\search;

use moonland\phpexcel\Excel;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PayOrder;
use common\helper\Helper;
use common\models\Product;

/**
 * PayOrderSearch represents the model behind the search form of `common\models\PayOrder`.
 */
class PayOrderSearch extends PayOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'pay_channel_id', 'user_id',  'pay_money', 'profit_rate', 'cost_rate',  'status', 'created_at', 'notify_at', 'success_at', 'query_at', 'updated_at'], 'integer'],
            [['channel_code', 'channel_account', 'user_account', 'sys_order_id', 'user_order_id', 'supplier_order_id'], 'safe'],
            [['user_money', 'cost_money', 'profit_money'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PayOrder::find();
//        $query->with(Product::TABLE_NAME);
//        $query->with(PayChannel::TABLE_NAME);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $lCreatedAt = Helper::cuttingDateRange($this->created_at);
        if ($lCreatedAt !== []){
            $query->andFilterWhere(['between',  'created_at',  $lCreatedAt[0], $lCreatedAt[1]]);
        }

        $lUpdatedAt = Helper::cuttingDateRange($this->updated_at);
        if ($lUpdatedAt !== []){
            $query->andFilterWhere(['between',  'updated_at',  $lUpdatedAt[0], $lUpdatedAt[1]]);
        }

        $lSuccessTime = Helper::cuttingDateRange($this->success_at);
        if ($lCreatedAt !== []){
            $query->andFilterWhere(['between',  'success_at',  $lSuccessTime[0], $lSuccessTime[1]]);
        }

        $lNotifyTime = Helper::cuttingDateRange($this->notify_at);
        if ($lNotifyTime !== []){
            $query->andFilterWhere(['between',  'notify_at',  $lNotifyTime[0], $lNotifyTime[1]]);
        }

        $lQueryTime = Helper::cuttingDateRange($this->query_at);
        if ($lQueryTime !== []){
            $query->andFilterWhere(['between',  'query_at',  $lQueryTime[0], $lQueryTime[1]]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'pay_channel_id' => $this->pay_channel_id,
            'user_id' => $this->user_id,
            'user_account' => $this->user_account,
            'pay_money' => $this->pay_money,
            'profit_rate' => $this->profit_rate,
            'cost_rate' => $this->cost_rate,
            'user_money' => $this->user_money,
            'cost_money' => $this->cost_money,
            'profit_money' => $this->profit_money,
            'inform_num' => $this->inform_num,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'pay_channel_code', $this->pay_channel_code])
            ->andFilterWhere(['like', 'pay_channel_account', $this->pay_channel_account])
            ->andFilterWhere(['like', 'pay_channel_account_extra', $this->pay_channel_account_extra])
            ->andFilterWhere(['like', 'md5_key', $this->md5_key])
            ->andFilterWhere(['like', 'public_key', $this->public_key])
            ->andFilterWhere(['like', 'private_key', $this->private_key])
            ->andFilterWhere(['like', 'sys_order_id', $this->sys_order_id])
            ->andFilterWhere(['like', 'user_order_id', $this->user_order_id])
            ->andFilterWhere(['like', 'supplier_order_id', $this->supplier_order_id])
            ->andFilterWhere(['like', 'user_notify_url', $this->user_notify_url])
            ->andFilterWhere(['like', 'user_callback_url', $this->user_callback_url])
            ->andFilterWhere(['like', 'user_extra_field', $this->user_extra_field]);

        return $dataProvider;
    }


    /**
     * 导出订单
     */
    public function export($params)
    {
        $omProduct = new Product();
        $lProductIdToName = $omProduct->getIdToNameList();

        $omPayChannel = new PayChannel();
        $lChannelIdToName = $omPayChannel->getIdToNameList();

        $dataProvider = $this->search($params);

        return Excel::export([
            'models' => $dataProvider->query->all(),
            'fileName'=> [date('Ymd') . '_' . 'Export'],
            'columns'=>[
                [
                    'attribute'=>'sys_order_id',
                    'value' => function($data){
                        return $data->sys_order_id . ' ';
                    },
                ],
                [
                    'attribute'=>'user_order_id',
                    'value' => function($data){
                        return $data->user_order_id . ' ';
                    },
                ],
                [
                    'attribute'=>'supplier_order_id',
                    'value' => function($data){
                        return $data->supplier_order_id . ' ';
                    },
                ],
                'user_id',
                [
                    'attribute'=>'product_id',
                    'value' => function($data) use ($lProductIdToName){
                        return $lProductIdToName[$data->product_id];
                    },
                ],
                [
                    'attribute'=>'pay_channel_id',
                    'value' => function($data) use ($lChannelIdToName){
                        return $lChannelIdToName[$data->pay_channel_id];
                    },
                ],
                'pay_money',
                'user_money',
                'cost_money',
                'profit_money',
                'profit_rate',
                'cost_rate',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute' => 'notify_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute' => 'success_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute'=>'status',
                    'value' => function($data){
                        return PayOrder::enumState('status', $data->status);
                    },
                ],
            ],
            'headers'=> $this->attributeLabels(),
        ]);
    }

    public function getProductGroupMoneySum($userId = null)
    {

        $select = [
            'product_id',
            'sum(`pay_money`) as pay_money','sum(`user_money`) as user_money',
            'sum(`cost_money`) as cost_money', 'sum(`profit_money`) as profit_money',
        ];
        return self::find()
            ->with(Product::TABLE_NAME)
            ->select($select)
            ->andFilterWhere(['user_id' => $userId])
            ->andFilterWhere(['in','status', $this->userHavePayMoneyStatus()])
            ->groupBy('product_id')->all();
    }

    public function getBeforetimeOrder($day = '-30 day',$userId = null)
    {
        return self::find()
            ->andFilterWhere(['user_id'=>$userId])
            ->andFilterWhere(['between',  'notify_at',  strtotime($day), time()])
            ->andFilterWhere(['in', 'status', $this->userHavePayMoneyStatus()])
            ->orderBy('notify_at')
            ->all();
    }
}
