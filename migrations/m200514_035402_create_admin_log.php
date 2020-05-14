<?php

use yii\db\Migration;

/**
 * Class m200514_035402_create_admin_log
 */
class m200514_035402_create_admin_log extends Migration
{
    const TABLE_NAME = '{{%admin_log}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' =>  $this->primaryKey(),
            'route' => $this->string()->notNull()->defaultValue(''),
            'admin_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'admin_name' => $this->string()->notNull()->defaultValue(''),
            'admin_ip' => $this->string()->notNull()->defaultValue(''),
            'admin_agent' => $this->string()->notNull()->defaultValue(''),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_035402_create_admin_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_035402_create_admin_log cannot be reverted.\n";

        return false;
    }
    */
}
