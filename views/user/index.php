<?php
/** @var $this \yii\base\View */
/** @var $filter \app\models\UserSearch */
/** @var $dataProvider \yii\data\DataProviderInterface */
$this->params['breadcrumbs'][] = [
    'label' => 'Users',
];
?>
<div class="users-index">
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $filter,
        'columns' => [
            ['class' => \yii\grid\SerialColumn::className()],
            'login',
            [
                'attribute' => 'balance',
                'format' => 'currency',
            ]
        ],
    ]); ?>
</div>
