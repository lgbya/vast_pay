<?php

use yii\db\Migration;

/**
 * Class m200514_054714_create_draw_money_order
 */
class m200514_054714_create_draw_money_order extends Migration
{

    const TABLE_NAME = '{{%draw_money_order}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'sys_order_id' => $this->string()->notNull(),
            'account_name' => $this->string()->notNull(),
            'account_number' => $this->string()->notNull(),
            'receipt_number' => $this->string()->notNull(),
            'money' => $this->integer()->unsigned()->defaultValue('0'),
            'remark' => $this->string()->notNull()->defaultValue(''),
            'status' => $this->tinyInteger()->unsigned()->defaultValue('0'),
            'success_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('user_id', self::TABLE_NAME, ['user_id'], false);
        $this->createIndex('sys_order_id', self::TABLE_NAME, ['sys_order_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054714_create_draw_money_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054714_create_draw_money_order cannot be reverted.\n";

        return false;
    }
    */
}
