<?php
namespace tests\models;

use app\models\LoginForm;
use app\models\TransferForm;
use app\tests\fixtures\UserFixture;
use Codeception\Specify;
use yii\codeception\DbTestCase;
use yii\codeception\TestCase;

class TransferFormTest extends TestCase
{
    private $model;

    public function testTransferFormCorrect()
    {
        $this->model = new TransferForm([
            'user' => 'test',
            'amount' => 100,
        ]);
        expect_that($this->model->validate());
    }

    public function testTransferFormUserWrong()
    {
        $this->model = new TransferForm([
            'user' => '....',
        ]);

        expect_not($this->model->validate());
        expect($this->model->errors)->hasKey('user');
    }

    public function testTransferFormAmountWrong()
    {
        $this->model = new TransferForm([
            'amount' => '....',
        ]);

        expect_not($this->model->validate());
        expect($this->model->errors)->hasKey('amount');
    }

}
