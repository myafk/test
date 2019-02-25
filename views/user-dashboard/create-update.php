<?php

/* @var $this yii\web\View */
/* @var $model \app\models\UserDashboardForm*/

if ($model->user->isNewRecord)
    $this->title = 'Создание нового пользователя';
else
    $this->title = 'Редактирование пользователя "' . $model->user->username . '"';

$this->params['breadcrumbs'][] = [
    'label' => 'Пользователи',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-dashboard-form col-md-6">
    <?php $form = \yii\bootstrap\ActiveForm::begin(); ?>
    <?= \yii\helpers\Html::hiddenInput('is-new-record', $model->user->isNewRecord, ['id' => 'is-new-record']); ?>

    <?= $form->field($model, 'status')->dropDownList(\app\models\User::getStatus()); ?>
    <?= $form->field($model, 'username')->textInput(); ?>
    <?= $form->field($model, 'email')->textInput(); ?>
    <?= $form->field($model, 'password')->passwordInput(); ?>
    <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php if (!$model->user->isNewRecord) : ?>
        <?= \yii\helpers\Html::a('Управление правами', ['/rbac/assignment/view', 'id' => $model->user->primaryKey], ['class' => 'btn btn-secondary']); ?>
    <?php endif; ?>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
</div>

