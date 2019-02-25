<?php

namespace app\controllers;

use app\components\Controller;
use app\components\NotFoundHttpException;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class NewsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
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
        $dp = new ActiveDataProvider([
            'query' => News::find()->andWhere(['status' => News::STATUS_PUBLISHED]),
            'pagination' => [
                'defaultPageSize' => 4,
                'pageSizeLimit' => [4, 10, 100],
            ],
        ]);

        return $this->render('index', ['dp' => $dp]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$model = News::find()->andWhere(['id' => $id, 'status' => News::STATUS_PUBLISHED])->one())
            throw new NotFoundHttpException();

        return $this->render('view', ['model' => $model]);
    }

}