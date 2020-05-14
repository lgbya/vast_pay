<?php

use yii\db\Migration;

/**
 * Class m200514_082449_dump_base_data
 */
class m200514_082449_dump_base_data extends Migration
{

    const FILE_PATH = '/migrations/base_data.sql';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        $sqlStr = file_get_contents(Yii::$app->basePath . self::FILE_PATH);
        $lSqlStr = explode("\n", trim( $sqlStr, "\n"));

        foreach ($lSqlStr as $k=>$v){
            if (!Yii::$app->db->createCommand($v)->execute()){
                $transaction->rollBack();
                return false;
            }
        }
        $transaction->commit();
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200514_082449_dump_base_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200514_082449_dump_base_data cannot be reverted.\n";

        return false;
    }
    */
}
