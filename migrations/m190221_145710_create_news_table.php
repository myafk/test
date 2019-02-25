<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m190221_145710_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(3)->notNull()->defaultValue(10)->comment('0 - Unpublished\n10 - Published'),
            'owner_id' => $this->integer(11)->null(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'short_description' => $this->text(),
            'description' => $this->text(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

        $this->createIndex('owner_id', '{{%news}}', 'owner_id', false);

        $this->addForeignKey(
            'fk_news__owner_id',
            '{{%news}}', 'owner_id',
            '{{%users}}', 'id',
            'SET NULL', 'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_news__owner_id', '{{%news}}');
        $this->dropTable('{{%news}}');
    }
}
