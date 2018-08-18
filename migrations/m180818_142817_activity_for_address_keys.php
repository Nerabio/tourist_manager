<?php

use yii\db\Migration;

/**
 * Class m180818_142817_activity_for_address_keys
 */
class m180818_142817_activity_for_address_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-activity-adress_id', '{{%activity}}', 'adress_id');
        $this->addForeignKey('fk-activity-adress_id', '{{%activity}}', 'adress_id' ,'address', 'id', 'NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-activity-adress_id', 'activity');
        $this->dropIndex('idx-activity-adress_id', 'activity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180818_142817_activity_for_address_keys cannot be reverted.\n";

        return false;
    }
    */
}
