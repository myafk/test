<?php

/* @var $this yii\web\View */
/* @var $columns array */
/* @var $searchModel \app\models\NewsDashboardSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $columns,
    'pjax' => true,
    'toolbar' => [
        [
            'content' =>
                \yii\helpers\Html::a('Добавить новость', \yii\helpers\Url::toRoute('create-update'), ['class' => 'btn btn-success', 'data-pjax' => 0]) . ' ' .
                \yii\helpers\Html::a('Сбросить', [''], ['class' => 'btn btn-outline-secondary', 'data-pjax' => 0]),
        ],
        '{export}',
        '{toggleData}',
    ],
    'panel' => [
        'type' => \kartik\grid\GridView::TYPE_PRIMARY,
    ],
]); ?>