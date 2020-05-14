<?php

use yii\db\Migration;

/**
 * Class m200514_054830_create_pay_channel_account
 */
class m200514_054830_create_pay_channel_account extends Migration
{
    const TABLE_NAME = '{{%pay_channel_account}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'pay_channel_id' => $this->integer()->unsigned()->notNull(),
            'account' => $this->string()->notNull()->defaultValue(''),
            'appid' => $this->string()->notNull()->defaultValue(''),
            'md5_key' => $this->string()->notNull()->defaultValue(''),
            'private_key' => $this->string()->notNull()->defaultValue(''),
            'public_key' => $this->string()->notNull()->defaultValue(''),
            'extra' => $this->string()->notNull()->defaultValue(''),
            'weight' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1),
            'is_del' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('pay_channel_id', self::TABLE_NAME, ['pay_channel_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054830_create_pay_channel_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054830_create_pay_channel_account cannot be reverted.\n";

        return false;
    }
    */
}
