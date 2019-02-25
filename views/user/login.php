<?php

/* @var $this yii\web\View */
/* @var $model \app\models\LoginForm */

use yii\helpers\Html;

$this->title = 'Логин';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-form col-md-6">
    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'id' => 'form-login',
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'rememberMe')->checkbox(); ?>


    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>

    <?php \yii\bootstrap\ActiveForm::end(); ?>
</div>
