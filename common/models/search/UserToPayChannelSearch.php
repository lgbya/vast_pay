<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserToPayChannel;

/**
 * PayOrderSearch represents the model behind the search form of `common\models\PayOrder`.
 */
class UserToPayChannelSearch extends UserToPayChannel
{

    public function rules()
    {
        return [
            [['id', 'user_id', 'pay_channel_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserToPayChannel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pay_channel_id' => $this->pay_channel_id,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }

}
