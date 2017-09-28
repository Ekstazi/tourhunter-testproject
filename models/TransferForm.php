<?php

namespace app\models;


use yii\base\Model;

/**
 * Class TransferForm
 * @package app\models
 */
class TransferForm extends Model
{
    /**
     * @var float
     */
    public $amount;
    /**
     * @var string
     */
    public $user;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user', 'amount'], 'required'],
            ['amount', 'number', 'min' => 1],
            ['user', 'match', 'pattern' => '~^[\w]+$~'],
            ['user', 'compare', 'compareValue' => \Yii::$app->user->identity->login, 'operator' => '!=']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user'   => \Yii::t('transfer', 'User to'),
            'amount' => \Yii::t('transfer', 'Amount'),
        ];
    }


}