<?php

namespace app\controllers;

use app\components\Billing;
use app\models\BalanceHistorySearch;
use app\models\LoginForm;
use app\models\TransferForm;
use app\models\UserSearch;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * @var Billing
     */
    protected $billing;

    public function __construct($id, Module $module, Billing $billing, array $config = [])
    {
        $this->billing = $billing;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex()
    {
        //var_dump(new User())
        $model = new UserSearch();
        $dataProvider = $model->search(\Yii::$app->request->get());
        return $this->render('index', [
            'filter'       => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionHistory()
    {
        //var_dump(new User())
        $model = new BalanceHistorySearch();
        $dataProvider = $model->search(\Yii::$app->request->get());
        return $this->render('history', [
            'filter'       => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTransfer()
    {
        $form = new TransferForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $this->billing->transfer(
                \Yii::$app->user->identity->login,
                $form->user,
                $form->amount
            );
            return $this->redirect(['history']);
        }
        return $this->render('transfer', [
            'model' => $form,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

}