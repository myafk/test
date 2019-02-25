<?php

namespace app\controllers;

use app\components\Controller;
use app\models\NewsDashboard;
use app\models\NewsDashboardForm;
use app\models\NewsDashboardSearch;
use kartik\grid\EditableColumn;
use Yii;
use kartik\grid\GridView;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ForbiddenHttpException;
use app\components\NotFoundHttpException;
use yii\web\Response;

class NewsDashboardController extends Controller
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
                        'roles' => ['viewNewsGrid'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-update'],
                        'roles' => ['createNews', 'updateNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['editable'],
                        'roles' => ['createNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewNews'],
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
        $searchModel = new NewsDashboardSearch();
        $columns = [
            'id',
            'title',
            'description',
            [
                'class' => EditableColumn::class,
                'filter' => NewsDashboard::getStatus(),
                'value' => function($model) {
                    return NewsDashboard::getStatus($model->status);
                },
                'editableOptions' => [
                    'inputType' => 'dropDownList',
                    'data' => NewsDashboard::getStatus(),
                    'ajaxSettings' => [
                        'url' => Url::toRoute('editable'),
                    ]
                ],
                'attribute' => 'status',
            ],
            [
                'filterType' => GridView::FILTER_DATE_RANGE,
                'attribute' => 'created_at',
                'filterWidgetOptions' => [
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'cancelLabel' => 'Clear',
                            'format' => 'd-m-Y',
                        ]
                    ],
                ],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
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
                    'update' => function($model) {
                        return Yii::$app->user->can('updateNews', ['post' => $model]);
                    },
                    'delete' => function($model) {
                        return Yii::$app->user->can('deleteNews', ['post' => $model]);
                    }
                ],
                'header' => 'Действия',
                'class' => ActionColumn::class,
            ],
        ];
        $query = NewsDashboardSearch::find();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columns]);
    }

    /**
     * @param int|null $id
     * @return string|Response
     * @throws NotFoundHttpException|ForbiddenHttpException
     */
    public function actionCreateUpdate($id = null)
    {
        $news = null;
        if ($id && !$news = NewsDashboard::findById($id))
            throw new NotFoundHttpException();
        /* @var $news NewsDashboard|null */
        if ($news && !Yii::$app->user->can('updateNews', ['post' => $news]))
            throw new ForbiddenHttpException();
        if (!$news && !Yii::$app->user->can('createNews'))
            throw new ForbiddenHttpException();
        $model = new NewsDashboardForm($news, Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Успешно сохранено');
            return $this->redirect(Url::current(['id' => $model->news->primaryKey]));
        }

        return $this->render('create-update', ['model' => $model]);
    }

    /**
     * @return array|null
     * @throws NotFoundHttpException|InvalidArgumentException|ForbiddenHttpException|\yii\base\InvalidConfigException
     */
    public function actionEditable()
    {
        $post = Yii::$app->request->post();
        if (ArrayHelper::getValue($post, 'editableAttribute') !== 'status')
            throw new InvalidArgumentException();
        $id = ArrayHelper::getValue($post, 'editableKey');
        $news = null;
        if ($id && !$news = NewsDashboard::findById($id))
            throw new NotFoundHttpException();
        /* @var $news NewsDashboard|null */
        if (!Yii::$app->user->can('updateNews', ['post' => $news]))
            throw new ForbiddenHttpException();
        $model = new NewsDashboardForm($news, Yii::$app->user->id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = [$model->formName() => ArrayHelper::getValue($post, 'NewsDashboardSearch.' . ArrayHelper::getValue($post, 'editableIndex'))];
        if ($model->load($postData)) {
            if ($model->save()) {
                $value = NewsDashboard::getStatus($model->status);
                return ['output' => $value, 'message' => ''];
            }
            else {
                return ['output' => '', 'message' => $model->getFirstError('status')];
            }
        }
        return null;
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException|\Throwable|\yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if (!$news = NewsDashboard::findById($id))
            throw new NotFoundHttpException();
        if (!Yii::$app->user->can('deleteNews', ['post' => $news]))
            throw new ForbiddenHttpException();
        if ($news->delete()) {
            Yii::$app->session->setFlash('success', 'Успешно удалено');
        }
        return $this->redirect('index');
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$news = NewsDashboard::findById($id))
            throw new NotFoundHttpException();
        return $this->redirect(['/news', 'id' => $id]);
    }

}