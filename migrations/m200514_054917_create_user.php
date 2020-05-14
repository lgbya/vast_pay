<?php

use yii\db\Migration;

/**
 * Class m200514_054917_create_user
 */
class m200514_054917_create_user extends Migration
{

    const TABLE_NAME = '{{%user}}';

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
            'pay_password_hash' => $this->string()->notNull(),
            'pay_password_reset_token' => $this->string(),
            'email' => $this->string()->notNull(),
            'account' => $this->string()->unique()->notNull(),
            'pay_md5_key' => $this->string()->notNull(),
            'money' => $this->decimal(12,3)->notNull()->defaultValue('0.000'),
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
        echo "m200514_054917_create_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054917_create_user cannot be reverted.\n";

        return false;
    }
    */
}
