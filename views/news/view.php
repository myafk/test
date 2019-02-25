<?php

/* @var $this yii\web\View */
/* @var $model \app\models\News*/

$this->title = 'Новость "' . $model->title . '"';

$this->params['breadcrumbs'][] = [
    'label' => 'Новости',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news">
    <p><?= \yii\helpers\Html::img($model->getImageUrl(), ['style' => ['max-width' => '200px;']]); ?></p>
    <p><?= $model->description; ?></p>
</div>
