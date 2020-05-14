<?php

namespace common\models\search;

use common\helper\Helper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminLog;

/**
 * AdminLogSearch represents the model behind the search form of `common\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'admin_id'], 'integer'],
            [['route', 'admin_ip', 'admin_agent', 'admin_name'], 'safe'],
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
        $query = AdminLog::find();

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

            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
        ]);

        $lCreatedAt = Helper::cuttingDateRange($this->created_at);
        if ($lCreatedAt !== []){
            $query->andFilterWhere(['between',  'created_at',  $lCreatedAt[0], $lCreatedAt[1]]);
        }

        $query->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'admin_ip', $this->admin_ip])
            ->andFilterWhere(['like', 'admin_agent', $this->admin_agent])
            ->andFilterWhere(['like', 'admin_name', $this->admin_name]);

        return $dataProvider;
    }
}
