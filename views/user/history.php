<?php
/** @var $this \yii\base\View */
use yii\bootstrap\Html;

/** @var $filter \app\models\UserSearch */
/** @var $dataProvider \yii\data\DataProviderInterface */
$this->params['breadcrumbs'][] = [
    'label' => 'Balance',
];
?>

<div class="history-index">
    <div class="balance panel panel-success panel-collapse">
        <div class="panel-body">
            <h4>
                Your balance is: <?= Yii::$app->formatter->asCurrency(Yii::$app->user->identity->balance);?>
                <?= Html::a('Transfer to user', ['user/transfer'], ['class' => 'btn btn-success']);?>
            </h4>

        </div>
    </div>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $filter,
        'columns'      => [
            [
                'class' => \yii\grid\SerialColumn::className(),
            ],
            [
                'attribute' => 'amount_before',
                'format'    => 'currency',
            ],
            [
                'attribute' => 'amount',
                'format'    => 'currency',
            ],
            [
                'attribute' => 'amount_after',
                'format'    => 'currency',
            ],
            [
                'attribute' => 'operation_time',
                'format'    => 'datetime',
            ],
            'message',
        ],
    ]); ?>
</div>
