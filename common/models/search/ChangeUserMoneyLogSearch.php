<?php

namespace common\models\search;

use moonland\phpexcel\Excel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ChangeUserMoneyLog;
use common\helper\Helper;

/**
 * ChangeUserMoneyLogSearch represents the model behind the search form of `common\models\ChangeUserMoneyLog`.
 */
class ChangeUserMoneyLogSearch extends ChangeUserMoneyLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'change_money', 'before_money', 'after_money', 'type', 'created_at', 'updated_at'], 'integer'],
            [['extra'], 'safe'],
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
        $query = ChangeUserMoneyLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => Yii::$app->params['pagination'],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'change_money' => $this->change_money,
            'before_money' => $this->before_money,
            'after_money' => $this->after_money,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'extra', $this->extra]);

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
            'fileName'=> [date('Ymd') . '_' . 'Export'],
            'columns'=>[
                'user_id',
                'change_money',
                'before_money',
                'after_money',
                'extra',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
                [
                    'attribute'=>'type',
                    'value' => function($data){
                        return ChangeUserMoneyLog::enumState('type', $data->type);
                    },
                ],
            ],
            'headers'=> $this->attributeLabels(),
        ]);
    }
}
