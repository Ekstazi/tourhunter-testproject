<?php

namespace app\tests\fixtures;

use app\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\User';

    public function load()
    {
        User::deleteAll();
        parent::load();
    }


}