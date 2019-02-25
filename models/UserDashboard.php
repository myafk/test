<?php

namespace app\models;

use lav45\activityLogger\ActiveLogBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class UserDashboard
 * @package app\models
 * Модель для бекенда, чтобы можно было подключить лог-бехавиор отдельно от основной модели,
 * в шаблоне адвансед он просто бы находился в бекенде с названием User, но тут приходится извращаться
 */
class UserDashboard extends User
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => ActiveLogBehavior::class,
                'attributes' => [
                    'username',
                    'email',
                    'status' => [
                        'list' => 'statusList',
                    ],
                ]
            ]
        ];
    }

}