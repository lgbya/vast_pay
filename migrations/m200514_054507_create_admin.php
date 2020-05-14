<?php

use yii\db\Migration;

/**
 * Class m200514_054507_create_admin
 */
class m200514_054507_create_admin extends Migration
{

    const TABLE_NAME = '{{%admin}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(10),
            'pre_login_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'pre_login_ip' => $this->string()->notNull()->defaultValue(''),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054507_create_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054507_create_admin cannot be reverted.\n";

        return false;
    }
    */
}
