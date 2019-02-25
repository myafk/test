<?php

use yii\db\Migration;

/**
 * Class m190225_044152_insert_data_to_news
 */
class m190225_044152_insert_data_to_news extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%news}}',
            [
                'id', 'status', 'owner_id', 'title', 'image', 'short_description', 'description', 'created_at', 'updated_at'
            ],
            [
                [
                    'id' => 1,
                    'status' => 10,
                    'owner_id' => 4,
                    'title' => 'Новость от админа №1',
                    'image' => '8c0becbc6f5b38dd034a81397c23a1bb.jpg',
                    'short_description' => 'Краткое описание',
                    'description' => 'Полное описание',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 2,
                    'status' => 10,
                    'owner_id' => 4,
                    'title' => 'Новость от админа №2',
                    'image' => '8c0becbc6f5b38dd034a81397c23a1bb.jpg',
                    'short_description' => 'Краткое описание',
                    'description' => 'Полное описание',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 3,
                    'status' => 10,
                    'owner_id' => 4,
                    'title' => 'Новость от админа №3',
                    'image' => '8c0becbc6f5b38dd034a81397c23a1bb.jpg',
                    'short_description' => 'Краткое описание',
                    'description' => 'Полное описание',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 4,
                    'status' => 10,
                    'owner_id' => 3,
                    'title' => 'Новость от менеджера №1',
                    'image' => '8c0becbc6f5b38dd034a81397c23a1bb.jpg',
                    'short_description' => 'Краткое описание',
                    'description' => 'Полное описание',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
                [
                    'id' => 5,
                    'status' => 10,
                    'owner_id' => 3,
                    'title' => 'Новость от менеджера №2',
                    'image' => '8c0becbc6f5b38dd034a81397c23a1bb.jpg',
                    'short_description' => 'Краткое описание',
                    'description' => 'Полное описание',
                    'created_at' => '1551005612',
                    'updated_at' => '1551005612',
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('{{%news}}');
        $this->execute('ALTER TABLE {{%news}} AUTO_INCREMENT = 1;');
    }
}
