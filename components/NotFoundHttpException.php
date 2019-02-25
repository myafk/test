<?php

namespace app\components;

class NotFoundHttpException extends \yii\web\NotFoundHttpException
{

	public function __construct($message = 'Страница не найдена', $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}