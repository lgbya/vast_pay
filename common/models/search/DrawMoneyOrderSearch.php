<?php

namespace common\models\search;

use common\helper\Helper;
use moonland\phpexcel\Excel;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DrawMoneyOrder;

/**
 * DrawMoneyOrderSearch represents the model behind the search form of `common\models\DrawMoneyOrder`.
 */
class DrawMoneyOrderSearch extends DrawMoneyOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'money', 'status', 'created_at', 'updated_at', 'success_at'], 'integer'],
            [['sys_order_id', 'account_name', 'account_number', 'receipt_number', 'remark'], 'safe'],
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
        $query = DrawMoneyOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

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

        $lSuccessAt = Helper::cuttingDateRange($this->success_at);
        if ($lUpdatedAt !== []){
            $query->andFilterWhere(['between',  'success_at',  $lSuccessAt[0], $lSuccessAt[1]]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'money' => $this->money,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'sys_order_id', $this->sys_order_id])
            ->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }

    /**
     * 导出订单
     */
    public function export($params)
    {
        $dataProvider = $this->search($params);
        return Excel::export([
            'models' => $dataProvider->query->all(),
            'columns'=>[
                'user_id',
                'sys_order_id',
                'account_name',
                'account_number',
                'receipt_number',
                'money',
                'remark',
                [
                    'attribute' => 'status',
                    'value' => function($data) {
                        return DrawMoneyOrder::enumState('status', $data->status) ;
                    },
                ],
                [
                    'attribute' => 'success_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
            ],
            'headers'=> $this->attributeLabels(),
        ]);
    }

}
