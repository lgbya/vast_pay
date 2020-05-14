<?php

use yii\db\Migration;

/**
 * Class m200514_054815_create_pay_channel
 */
class m200514_054815_create_pay_channel extends Migration
{
    const TABLE_NAME = '{{%pay_channel}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->unique()->notNull(),
            'code' => $this->string()->unique()->notNull(),
            'profit_rate' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'cost_rate' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'weight' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'request_url' => $this->string()->notNull()->defaultValue(''),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1),
            'is_del' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('product_id', self::TABLE_NAME, ['product_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054815_create_pay_channel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054815_create_pay_channel cannot be reverted.\n";

        return false;
    }
    */
}
