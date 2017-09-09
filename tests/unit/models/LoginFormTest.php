<?php
namespace tests\models;

use app\models\LoginForm;
use app\tests\fixtures\UserFixture;
use Codeception\Specify;
use yii\codeception\DbTestCase;

class LoginFormTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
        ];
    }


    private $model;

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
        ]);
        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongLogin()
    {
        $this->model = new LoginForm([
            'username' => '___!',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('username');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'demo',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('username');
    }

}
