<?php

use yii\db\Migration;

/**
 * Class m200514_054901_create_product
 */
class m200514_054901_create_product extends Migration
{

    const TABLE_NAME = '{{%product}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1),
            'is_del' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054901_create_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054901_create_product cannot be reverted.\n";

        return false;
    }
    */
}
