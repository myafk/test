<?php

/* @var $this yii\web\View */

/* @var $dp \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Новостей на странице: <b class="caret"></b></a>
            <?= \yii\bootstrap\Dropdown::widget([
                'items' => [
                    ['label' => 4, 'url' => \yii\helpers\Url::current(['per-page' => 4])],
                    ['label' => 10, 'url' => \yii\helpers\Url::current(['per-page' => 10])],
                    ['label' => 100, 'url' => \yii\helpers\Url::current(['per-page' => 100])]
                ]
            ]); ?>
        </div>
    </div>
    <?php foreach ($dp->models as $model) : ?>
        <?php /* @var \app\models\News $model */ ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if (Yii::$app->user->can('viewNews')) : ?>
                        <?= Html::a($model->title, ['view', 'id' => $model->primaryKey]); ?>
                    <?php else : ?>
                        <?= $model->title; ?>
                    <?php endif; ?>
                </div>
                <div class="panel-body">
                    <?= $model->short_description; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="col-md-12">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dp->pagination,
        ]); ?>
    </div>
</div>
