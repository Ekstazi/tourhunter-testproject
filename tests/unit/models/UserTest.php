<?php
namespace tests\models;

use app\models\User;
use app\tests\fixtures\UserFixture;
use yii\codeception\DbTestCase;

class UserTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
        ];
    }

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->login)->equals('test_login');

        expect_not(User::findIdentity(10));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('test_login'));
        expect($user->login)->equals('test_login');

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('test_login'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('test_login');
        expect_that($user->validateAuthKey('test_login'));
        expect_not($user->validateAuthKey('test'));
    }

}
