<?php
return [
    'viewLogs' => [
        'type' => 2,
        'description' => 'Просмотр логов',
    ],
    'rbacManager' => [
        'type' => 2,
        'description' => 'RBAC-менеджер',
    ],
    'viewUserGrid' => [
        'type' => 2,
        'description' => 'Просмотр таблицы пользователей',
    ],
    'createUser' => [
        'type' => 2,
        'description' => 'Добавить пользователя',
    ],
    'updateUser' => [
        'type' => 2,
        'description' => 'Обновить пользователя',
    ],
    'deleteUser' => [
        'type' => 2,
        'description' => 'Удаление пользователя',
    ],
    'viewNewsGrid' => [
        'type' => 2,
        'description' => 'Просмотр таблицы новостей',
    ],
    'createNews' => [
        'type' => 2,
        'description' => 'Добавить новость',
    ],
    'updateNews' => [
        'type' => 2,
        'description' => 'Обновить новость',
    ],
    'deleteNews' => [
        'type' => 2,
        'description' => 'Удалить новость',
    ],
    'updateOwnNews' => [
        'type' => 2,
        'description' => 'Обновить собственную новость',
        'ruleName' => 'isAuthor',
        'children' => [
            'updateNews',
        ],
    ],
    'deleteOwnNews' => [
        'type' => 2,
        'description' => 'Удалить собственную новость',
        'ruleName' => 'isAuthor',
        'children' => [
            'deleteNews',
        ],
    ],
    'viewNews' => [
        'type' => 2,
        'description' => 'Просмотреть новость',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'children' => [
            'viewNews',
        ],
    ],
    'manager' => [
        'type' => 1,
        'description' => 'Менеджер',
        'children' => [
            'viewNewsGrid',
            'createNews',
            'updateOwnNews',
            'viewNews',
            'deleteOwnNews',
        ],
    ],
    'administrator' => [
        'type' => 1,
        'description' => 'Администратор',
        'children' => [
            'manager',
            'rbacManager',
            'viewLogs',
            'updateNews',
            'deleteNews',
            'viewUserGrid',
            'createUser',
            'updateUser',
            'deleteUser',
        ],
    ],
];
