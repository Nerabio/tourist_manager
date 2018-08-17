<?php

use yii\db\Migration;

/**
 * Class m180809_093609_create_cache
 */
class m180809_093609_create_cache extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('cache', [
            'id' => $this->primaryKey(),
            'expire' => $this->integer(11),
            'data' => 'LONGBLOB'
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cache');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180809_093609_create_cache cannot be reverted.\n";

        return false;
    }
    */
}
