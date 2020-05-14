<?php

use yii\db\Migration;

/**
 * Class m200514_054741_create_email_code
 */
class m200514_054741_create_email_code extends Migration
{

    const TABLE_NAME = '{{%email_code}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
        ], $tableOptions);
        $this->createIndex('email', self::TABLE_NAME, ['email'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054741_create_email_code cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054741_create_email_code cannot be reverted.\n";

        return false;
    }
    */
}
