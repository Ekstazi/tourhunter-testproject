<?php

use yii\db\Migration;

class m170909_115616_balance_history extends Migration
{
    const TABLE_NAME = '{{%balance_history}}';

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id'             => $this->primaryKey(),
            'user_id'        => $this->integer()->notNull(),
            'amount_before'  => $this->decimal(10, 2)->notNull(),
            'amount'         => $this->decimal(10, 2)->notNull(),
            'amount_after'   => $this->decimal(10, 2)->notNull(),
            'message'        => $this->string()->defaultValue(''),
            'operation_time' => $this->integer()->notNull(),
        ]);

        if(Yii::$app->db->driverName != 'sqlite') {
            $this->addForeignKey('balance_user', self::TABLE_NAME, 'user_id', '{{%users}}', 'id');
        }
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }

}
