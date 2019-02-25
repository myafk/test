<?php

/* @var $this yii\web\View */
/* @var $model \app\models\SignUpForm */

use yii\helpers\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sign-up-form col-md-6">
    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'id' => 'form-signup',
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'email')->textInput(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>

    <?php \yii\bootstrap\ActiveForm::end(); ?>
</div>
