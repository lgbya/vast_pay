<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PayOrder;

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
            [['id', 'product_id', 'pay_channel_id', 'user_id',  'pay_money', 'profit_rate', 'cost_rate',  'status', 'created_at', 'notify_time', 'success_time', 'query_time', 'updated_at'], 'integer'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PayOrder::find();

        // add conditions that should always apply here

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

        $lSuccessTime = Helper::cuttingDateRange($this->success_time);
        if ($lCreatedAt !== []){
            $query->andFilterWhere(['between',  'success_time',  $lSuccessTime[0], $lSuccessTime[1]]);
        }

        $lNotifyTime = Helper::cuttingDateRange($this->notify_time);
        if ($lNotifyTime !== []){
            $query->andFilterWhere(['between',  'notify_time',  $lNotifyTime[0], $lNotifyTime[1]]);
        }

        $lQueryTime = Helper::cuttingDateRange($this->query_time);
        if ($lUpdatedAt !== []){
            $query->andFilterWhere(['between',  'updated_at',  $lQueryTime[0], $lQueryTime[1]]);
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
            'notify_time' => $this->notify_time,
            'success_time' => $this->success_time,
            'query_time' => $this->query_time,
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
}
