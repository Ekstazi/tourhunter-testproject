<?php

use yii\db\Migration;

class m170909_105129_users_data extends Migration
{
    const TABLE_NAME = '{{%users}}';

    public function safeUp()
    {
        $this->insert(self::TABLE_NAME, ['login' => 'test_login']);
        $this->insert(self::TABLE_NAME, ['login' => 'test_login2']);
        $this->insert(self::TABLE_NAME, ['login' => 'test_login3']);
        $this->insert(self::TABLE_NAME, ['login' => 'test_login4']);
    }

    public function safeDown()
    {
        $this->delete(self::TABLE_NAME);
    }

}
