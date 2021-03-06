<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Тест',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Новости', 'url' => ['/news/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/user/sign-up']];
        $menuItems[] = ['label' => 'Вход', 'url' => ['/user/login']];
    } else {
        $dashboardItems = [];
        if (Yii::$app->user->can('viewUserGrid')) {
            $dashboardItems[] = ['label' => 'Управление пользователями', 'url' => ['/user-dashboard/index']];
        }
        if (Yii::$app->user->can('viewNewsGrid')) {
            $dashboardItems[] = ['label' => 'Управление новостями', 'url' => ['/news-dashboard/index']];
        }
        if (Yii::$app->user->can('viewLogs')) {
            $dashboardItems[] = ['label' => 'Просмотр логов', 'url' => ['/logger']];
        }
        if (Yii::$app->user->can('rbacManager')) {
            $dashboardItems[] = ['label' => 'Управление ролями', 'url' => ['/rbac']];
        }
        if ($dashboardItems)
            $menuItems[] = ['label' => 'Управление', 'items' => $dashboardItems];
        $menuItems[] = ['label' => Yii::$app->user->identity->username . ' (Выход)', 'url' => '/user/logout', 'linkOptions' => ['data-method' => 'post']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
