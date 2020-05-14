<?php

use yii\db\Migration;

/**
 * Class m200514_054653_create_change_user_money_log
 */
class m200514_054653_create_change_user_money_log extends Migration
{
    const TABLE_NAME = '{{%change_user_money_log}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'change_money' => $this->decimal(12,3)->notNull(),
            'before_money' => $this->decimal(12,3)->unsigned()->notNull(),
            'after_money' => $this->decimal(12,3)->unsigned()->notNull(),
            'type' => $this->tinyInteger()->unsigned()->notNull(),
            'extra' => $this->string()->notNull()->defaultValue(''),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->createIndex('user_id', self::TABLE_NAME, ['user_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054653_create_change_user_money_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054653_create_change_user_money_log cannot be reverted.\n";

        return false;
    }
    */
}
