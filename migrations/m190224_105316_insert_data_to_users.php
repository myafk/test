<?php

use yii\db\Migration;

/**
 * Class m190224_105316_insert_data_to_users
 */
class m190224_105316_insert_data_to_users extends Migration
{

    public function safeUp()
    {
        $this->batchInsert('{{%users}}',
            [
                'id', 'status', 'username', 'email', 'auth_key', 'password_hash', 'created_at', 'updated_at'
            ],
            [
                [
                    'id' => 1,
                    'status' => 10,
                    'username' => 'user',
                    'email' => 'user@test.ru',
                    'auth_key' => 'UG3P_FvFPaz5FBLYxNpx7PYvCYVsvFG4',
                    'password_hash' => '$2y$13$BaBLhIT4q43Lco8.PtrNve0IvSKZ.zIKclsTPe1GSngXOqiVsIkLa',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 2,
                    'status' => 0,
                    'username' => 'not-active-user',
                    'email' => 'not-active-user@test.ru',
                    'auth_key' => 'UG3P_FvFPaz5FBLYxNpx7PYvCYVsvFG4',
                    'password_hash' => '$2y$13$BaBLhIT4q43Lco8.PtrNve0IvSKZ.zIKclsTPe1GSngXOqiVsIkLa',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 3,
                    'status' => 10,
                    'username' => 'manager',
                    'email' => 'manager@test.ru',
                    'auth_key' => 'UG3P_FvFPaz5FBLYxNpx7PYvCYVsvFG4',
                    'password_hash' => '$2y$13$BaBLhIT4q43Lco8.PtrNve0IvSKZ.zIKclsTPe1GSngXOqiVsIkLa',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 4,
                    'status' => 10,
                    'username' => 'administrator',
                    'email' => 'administrator@test.ru',
                    'auth_key' => 'UG3P_FvFPaz5FBLYxNpx7PYvCYVsvFG4',
                    'password_hash' => '$2y$13$BaBLhIT4q43Lco8.PtrNve0IvSKZ.zIKclsTPe1GSngXOqiVsIkLa',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('{{%users}}');
        $this->execute('ALTER TABLE {{%users}} AUTO_INCREMENT = 1;');
    }

}
