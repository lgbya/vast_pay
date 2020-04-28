<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PayChannel;

/**
 * PayChannelSearch represents the model behind the search form of `common\models\PayChannel`.
 */
class PayChannelSearch extends PayChannel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'profit_rate', 'cost_rate', 'weight', 'status', 'created_at', 'updated_at', 'is_del'], 'integer'],
            [['name', 'code', 'request_url'], 'safe'],
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
        $query = PayChannel::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'profit_rate' => $this->profit_rate,
            'cost_rate' => $this->cost_rate,
            'weight' => $this->weight,
            'status' => $this->status,
            'is_del' => $this->is_del,
        ]);

        $lCreatedAt = Helper::cuttingDateRange($this->created_at);
        if ($lCreatedAt !== []){
            $query->andFilterWhere(['between',  'created_at',  $lCreatedAt[0], $lCreatedAt[1]]);
        }

        $lUpdatedAt = Helper::cuttingDateRange($this->updated_at);
        if ($lUpdatedAt !== []){
            $query->andFilterWhere(['between',  'updated_at',  $lUpdatedAt[0], $lUpdatedAt[1]]);
        }


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'request_url', $this->request_url]);

        return $dataProvider;
    }
}
