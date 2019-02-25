<?php

namespace app\models;

use lav45\activityLogger\ActiveLogBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class NewsDashboard
 * @package app\models
 * Модель для бекенда, чтобы можно было подключить лог-бехавиор отдельно от основной модели,
 * в шаблоне адвансед он просто бы находился в бекенде с названием News, но тут приходится извращаться
 */
class NewsDashboard extends News
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => ActiveLogBehavior::class,
                'attributes' => [
                    'title',
                    'short_description',
                    'description',
                    'image',
                    'status' => [
                        'list' => 'statusList',
                    ],
                ]
            ]
        ];
    }

    public function transactions()
    {
        return [
            ActiveRecord::SCENARIO_DEFAULT => ActiveRecord::OP_ALL,
        ];
    }

}