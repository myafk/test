<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m190221_145648_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(11),
            'status' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('0 - Inactive\n10 - Active'),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255),
            'auth_key' => $this->string(32)->null()->defaultValue(null),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->null()->defaultValue(null),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'logged_at' => $this->integer(11)->notNull(),
        ]);

        $this->createIndex('username', '{{%users}}', 'username', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
