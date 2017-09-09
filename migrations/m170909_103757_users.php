<?php

use yii\db\Migration;

class m170909_103757_users extends Migration
{
    const TABLE_NAME='{{%users}}';
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'login' => $this->string(),
            'balance' => $this->decimal(10, 2)->defaultValue(0),
        ]);
        $this->createIndex('users_login', self::TABLE_NAME, 'login', true);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }

}
