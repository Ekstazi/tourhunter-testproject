<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%balance_history}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $amount_before
 * @property string $amount
 * @property string $amount_after
 * @property integer $operation_time
 * @property string $message
 */
class BalanceHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%balance_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'amount_before', 'amount', 'amount_after'], 'required'],
            [['user_id'], 'integer'],
            [['amount_before', 'amount', 'amount_after'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('balance', 'ID'),
            'user_id'        => Yii::t('balance', 'User ID'),
            'amount_before'  => Yii::t('balance', 'Amount Before'),
            'amount'         => Yii::t('balance', 'Amount'),
            'amount_after'   => Yii::t('balance', 'Amount After'),
            'operation_time' => Yii::t('balance', 'Operation Time'),
            'message'        => Yii::t('balance', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function behaviors()
    {
        return [
            'time' => [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'operation_time',
                'updatedAtAttribute' => 'operation_time',
            ]
        ];
    }


}
