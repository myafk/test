<?php

namespace app\components;

class ForbiddenHttpException extends \yii\web\ForbiddenHttpException
{

	public function __construct($message = 'Вам запрещён доступ к этому действию', $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}