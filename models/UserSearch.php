<?php

namespace app\models;


use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            ['login', 'string'],
            ['balance', 'string'],
        ];
    }

    public function search($params = [])
    {
        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->load($params) || !$this->validate($params)) {
            return $dataProvider;
        }

        $query
            ->andFilterCompare('balance', $this->balance)
            ->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }

}