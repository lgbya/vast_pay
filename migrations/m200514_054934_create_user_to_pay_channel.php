<?php

use yii\db\Migration;

/**
 * Class m200514_054934_create_user_to_pay_channel
 */
class m200514_054934_create_user_to_pay_channel extends Migration
{
    const TABLE_NAME = '{{%user_to_pay_channel}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'pay_channel_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->createIndex('user_id', self::TABLE_NAME, ['user_id', 'pay_channel_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054934_create_user_to_pay_channel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054934_create_user_to_pay_channel cannot be reverted.\n";

        return false;
    }
    */
}
