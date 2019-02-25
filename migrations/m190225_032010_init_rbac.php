<?php

use yii\db\Migration;

/**
 * Class m190225_032010_init_rbac
 */
class m190225_032010_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $viewLogs = $auth->createPermission('viewLogs');
        $viewLogs->description = 'Просмотр логов';
        $auth->add($viewLogs);

        $rbacManager = $auth->createPermission('rbacManager');
        $rbacManager->description = 'RBAC-менеджер';
        $auth->add($rbacManager);

        $viewUserGrid = $auth->createPermission('viewUserGrid');
        $viewUserGrid->description = 'Просмотр таблицы пользователей';
        $auth->add($viewUserGrid);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Добавить пользователя';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Обновить пользователя';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Удаление пользователя';
        $auth->add($deleteUser);

        $viewNewsGrid = $auth->createPermission('viewNewsGrid');
        $viewNewsGrid->description = 'Просмотр таблицы новостей';
        $auth->add($viewNewsGrid);

        $createNews = $auth->createPermission('createNews');
        $createNews->description = 'Добавить новость';
        $auth->add($createNews);

        $updateNews = $auth->createPermission('updateNews');
        $updateNews->description = 'Обновить новость';
        $auth->add($updateNews);

        $deleteNews = $auth->createPermission('deleteNews');
        $deleteNews->description = 'Удалить новость';
        $auth->add($deleteNews);

        $rule = new \app\rbac\AuthorRule;
        $auth->add($rule);

        $updateOwnNews = $auth->createPermission('updateOwnNews');
        $updateOwnNews->description = 'Обновить собственную новость';
        $updateOwnNews->ruleName = $rule->name;
        $auth->add($updateOwnNews);
        $auth->addChild($updateOwnNews, $updateNews);

        $deleteOwnNews = $auth->createPermission('deleteOwnNews');
        $deleteOwnNews->description = 'Удалить собственную новость';
        $deleteOwnNews->ruleName = $rule->name;
        $auth->add($deleteOwnNews);
        $auth->addChild($deleteOwnNews, $deleteNews);

        $viewNews = $auth->createPermission('viewNews');
        $viewNews->description = 'Просмотреть новость';
        $auth->add($viewNews);

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);
        $auth->addChild($user, $viewNews);

        $manager = $auth->createRole('manager');
        $manager->description = 'Менеджер';
        $auth->add($manager);
        $auth->addChild($manager, $viewNewsGrid);
        $auth->addChild($manager, $createNews);
        $auth->addChild($manager, $updateOwnNews);
        $auth->addChild($manager, $viewNews);
        $auth->addChild($manager, $deleteOwnNews);

        $admin = $auth->createRole('administrator');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $rbacManager);
        $auth->addChild($admin, $viewLogs);
        $auth->addChild($admin, $updateNews);
        $auth->addChild($admin, $deleteNews);
        $auth->addChild($admin, $viewUserGrid);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);

        $auth->assign($user, 1);
        $auth->assign($user, 2);
        $auth->assign($manager, 3);
        $auth->assign($admin, 4);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
