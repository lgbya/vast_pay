<?php

use yii\db\Migration;

/**
 * Class m200514_054846_create_pay_order
 */
class m200514_054846_create_pay_order extends Migration
{
    const TABLE_NAME = '{{%pay_order}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->unsigned()->notNull(),
            'pay_channel_id' => $this->integer()->unsigned()->notNull(),
            'pay_channel_code' => $this->string()->notNull(),
            'pay_channel_account' => $this->string()->notNull(),
            'pay_channel_account_extra' => $this->string()->notNull(),
            'md5_key' => $this->string()->notNull(),
            'public_key' => $this->string()->notNull(),
            'private_key' => $this->string()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'user_account' => $this->string()->notNull(),
            'sys_order_id' => $this->string(100)->notNull(),
            'user_order_id' => $this->string(100)->notNull(),
            'supplier_order_id' => $this->string(100)->notNull()->defaultValue(''),
            'profit_rate' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'cost_rate' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'pay_money' => $this->integer()->unsigned()->notNull(),
            'user_money' => $this->decimal(12,3)->unsigned()->notNull()->defaultValue('0.000'),
            'cost_money' => $this->decimal(12,3)->unsigned()->notNull()->defaultValue('0.000'),
            'profit_money' => $this->decimal(12,3)->unsigned()->notNull()->defaultValue('0.000'),
            'inform_num' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'user_notify_url' => $this->string()->notNull(),
            'user_callback_url' => $this->string()->notNull(),
            'user_extra_field' => $this->string()->notNull()->defaultValue(''),
            'user_sign_type' => $this->string()->notNull()->defaultValue('md5'),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'notify_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'success_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'query_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('user_id', self::TABLE_NAME, ['user_id'], false);
        $this->createIndex('sys_order_id', self::TABLE_NAME, ['sys_order_id'], true);
        $this->createIndex('user_order_id', self::TABLE_NAME, ['user_order_id', 'user_id'], false);
        $this->createIndex('supplier_order_id', self::TABLE_NAME, ['supplier_order_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054846_create_pay_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054846_create_pay_order cannot be reverted.\n";

        return false;
    }
    */
}
