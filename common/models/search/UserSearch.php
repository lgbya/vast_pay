<?php

namespace common\models\Search;

use moonland\phpexcel\Excel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\helper\Helper;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'money', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'account'], 'safe'],
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
        $query = User::find();

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
            'money' => $this->money,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

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

                'id',
                'username',
                'email',
                'money',
                [
                    'attribute' => 'pre_login_at',
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
                [
                    'attribute'=>'status',
                    'value' => function($data){
                        return User::enumState('status', $data->status);
                    },
                ],
            ],
            'headers'=> $this->attributeLabels(),
        ]);
    }
}
