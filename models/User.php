<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "{{%users}}".
 * @property int $id
 * @property string $login
 * @property float $balance
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findByUsername($token);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['login' => strtolower($username)]);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @param $username
     * @return static
     * @throws Exception
     */
    public static function findOrCreate($username)
    {
        if ($user = static::findByUsername($username)) {
            return $user;
        }

        $user = new static([
            'login' => strtolower($username),
            'balance' => 0,
        ]);
        if (!$user->save()) {
            throw new Exception('Cannot create user');
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->login;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'      => \Yii::t('user', 'Id'),
            'login'   => \Yii::t('user', 'Login'),
            'balance' => \Yii::t('user', 'Balance'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceHistory()
    {
        return $this->hasMany(BalanceHistory::className(), ['user_id' => 'id']);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['login', 'required'],
            ['login', 'match', 'pattern' => '~^[\w]+$~'],
            ['balance', 'number'],
        ];
    }


}
