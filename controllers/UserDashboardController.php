<?php

namespace app\controllers;

use app\components\Controller;
use app\models\UserDashboard;
use app\models\UserDashboardForm;
use app\models\UserDashboardSearch;
use Yii;
use kartik\grid\GridView;
use yii\filters\AccessControl;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ForbiddenHttpException;
use app\components\NotFoundHttpException;

class UserDashboardController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['viewUserGrid'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-update'],
                        'roles' => ['createUser', 'updateUser'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteUser'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserDashboardSearch();
        $columns = [
            'id',
            'username',
            'email',
            [
                'filter' => UserDashboard::getStatus(),
                'value' => function($model) {
                    return UserDashboard::getStatus($model->status);
                },
                'attribute' => 'status',
            ],
            [
                'filterType' => GridView::FILTER_DATE,
                'attribute' => 'created_at',
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                }
            ],
            [
                'filterType' => GridView::FILTER_DATE,
                'attribute' => 'logged_at',
                'value' => function($model) {
                    if ($model->logged_at)
                        return Yii::$app->formatter->asDatetime($model->logged_at);
                    else
                        return '';
                }
            ],
            [
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['create-update', 'id' => $model->primaryKey]), [
                            'title' => 'Редактировать',
                            'data-pjax' => 0,
                        ]);
                    }
                ],
                'visibleButtons' => [
                    'view' => false,
                ],

                'header' => 'Действия',
                'class' => ActionColumn::class,
            ],
        ];
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columns]);
    }

    /**
     * @param int|null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException|ForbiddenHttpException
     */
    public function actionCreateUpdate($id = null)
    {
        $user = null;
        if ($id && !$user = UserDashboard::findById($id))
            throw new NotFoundHttpException();
        /* @var $user \app\models\User|null */
        if ($user && !Yii::$app->user->can('updateUser'))
            throw new ForbiddenHttpException();
        if (!$user && !Yii::$app->user->can('createUser'))
            throw new ForbiddenHttpException();
        $model = new UserDashboardForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Успешно сохранено');
            return $this->redirect(Url::current(['id' => $model->user->primaryKey]));
        }

        return $this->render('create-update', ['model' => $model]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException|\Throwable|\yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if (!$user = UserDashboard::findById($id))
            throw new NotFoundHttpException();
        if ($user->delete()) {
            Yii::$app->session->setFlash('success', 'Успешно удалено');
        }
        return $this->redirect('index');
    }



}