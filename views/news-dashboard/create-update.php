<?php

/* @var $this yii\web\View */
/* @var $model \app\models\NewsDashboardForm*/

if ($model->news->isNewRecord)
    $this->title = 'Создание новой новости';
else
    $this->title = 'Редактирование новости "' . $model->news->title . '"';

$this->params['breadcrumbs'][] = [
    'label' => 'Новости',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-dashboard-form col-md-6">
    <?php $form = \yii\bootstrap\ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList(\app\models\News::getStatus(), ['prompt' => '-Выберите-']); ?>
    <?= $form->field($model, 'title')->textInput(); ?>
    <?php if ($model->news->image) : ?>
        <?= \yii\helpers\Html::img($model->news->getImageUrl(), ['style' => ['max-width' => '100px']]); ?>
    <?php endif; ?>
    <?= $form->field($model, 'imageUpload')->fileInput(['accept' => 'image/*']); ?>
    <?= $form->field($model, 'short_description')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 8]); ?>
    <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
</div>

