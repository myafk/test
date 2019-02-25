<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Cz48aKdPhBiuGVQUHVQm1nJ7W42CKLJg',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/',
            'rules' => [
                '' => 'site/index',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],
        'activityLogger' => [
            'class' => \lav45\activityLogger\Manager::class,
            'enabled' => true,
        ],
        'activityLoggerStorage' => [
            'class' => \lav45\activityLogger\DbStorage::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'logger' => [
            'class' => \lav45\activityLogger\modules\Module::class,
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'roles' => ['viewLogs'],
                        'allow' => true,
                    ],
                ],
            ],
            'entityMap' => [
                'user' => \app\models\UserDashboard::class,
                'news' => \app\models\NewsDashboard::class,
            ],
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
