<?php

namespace app\models;


use yii\data\ActiveDataProvider;

/**
 * Class UserSearch
 * @package app\models
 */
class UserSearch extends User
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['login', 'string'],
            ['balance', 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
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