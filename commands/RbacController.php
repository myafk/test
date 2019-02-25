<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    protected $auth;

	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		$auth->removeAll();
		$this->auth = $auth;

		$dashboard = $auth->createPermission('dashboard');
		$dashboard->name = 'Административная панель';
		$this->auth->add($dashboard);


	}
}