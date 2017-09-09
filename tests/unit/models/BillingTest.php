<?php
/**
 * Created by PhpStorm.
 * User: Maxim Furtuna
 * Date: 09.09.17
 * Time: 23:35
 */

namespace tests\models;


use app\components\Billing;
use app\models\User;
use app\tests\fixtures\UserFixture;
use yii\codeception\DbTestCase;
use yii\test\InitDbFixture;

class BillingTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
        ];
    }

    public function testTransferExistUsers()
    {
        $billing = \Yii::$container->get(Billing::className());
        $billing->transfer('test_login', 'test_login2', 100);
        expect_that(User::findByUsername('test_login')->balance == -100);
        expect_that(User::findByUsername('test_login2')->balance == 100);
    }

    public function testTransferNotExistUsers()
    {
        $billing = \Yii::$container->get(Billing::className());
        $billing->transfer('test_not_login', 'test_not_login2', 100);
        expect_that(User::findByUsername('test_not_login')->balance == -100);
        expect_that(User::findByUsername('test_not_login2')->balance == 100);
    }

    public function testTransferBadUserName()
    {
        $billing = \Yii::$container->get(Billing::className());
        try {
            $billing->transfer('.....', '....2', 100);
        } catch(\Exception $e) {
            return;
        }
        expect_that(false);
    }

}