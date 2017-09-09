<?php

namespace app\models;


use yii\data\ActiveDataProvider;

/**
 * Class BalanceHistorySearch
 * @package app\models
 */
class BalanceHistorySearch extends BalanceHistory
{
    public function rules()
    {
        return [
            [['amount_before', 'amount', 'amount_after'], 'safe'],
            ['message', 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $query = static::find();
        $query->andWhere(['user_id' => \Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->load($params) || !$this->validate($params)) {
            return $dataProvider;
        }

        $query
            ->andFilterCompare('amount_before', $this->amount_before)
            ->andFilterCompare('amount', $this->amount)
            ->andFilterCompare('amount_after', $this->amount_after)
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}