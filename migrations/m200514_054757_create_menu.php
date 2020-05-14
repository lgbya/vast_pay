<?php

use yii\db\Migration;

/**
 * Class m200514_054757_create_menu
 */
class m200514_054757_create_menu extends Migration
{

    const TABLE_NAME = '{{%menu}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'parent' => $this->integer(),
            'route' => $this->string(),
            'order' => $this->integer(),
            'data' => $this->binary(),
            "FOREIGN KEY ([[parent]]) REFERENCES ".self::TABLE_NAME."([[id]]) ON DELETE SET NULL ON UPDATE CASCADE",
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_054757_create_menu cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_054757_create_menu cannot be reverted.\n";

        return false;
    }
    */
}
