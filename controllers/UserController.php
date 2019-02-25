<?php

namespace app\controllers;

use app\components\Controller;
use app\models\LoginForm;
use app\models\SignUpForm;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'sign-up', 'login'],
                'rules' => [
                    [
                        'actions' => ['sign-up', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string|Response
     */
    public function actionSignUp()
    {
        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
            Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались');
            return $this->goHome();
        }
        return $this->render('sign-up', ['model' => $model]);
    }

    /**
     * @return string|Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Вы успешно вошли');
            return $this->goHome();
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logs out the current user.
     *
     * @return string|Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}