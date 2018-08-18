<?php

use yii\db\Migration;

/**
 * Class m180818_141515_adress_table
 */
class m180818_141515_address_table extends Migration
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

        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'type' => $this->integer()->defaultValue(0),
            'creator_user_id' => $this->integer()->defaultValue(null),
            'modyfy_user_id' => $this->integer()->defaultValue(null),
            'created_at' => 'timestamp DEFAULT current_timestamp',
            'updated_at' => 'timestamp DEFAULT current_timestamp ON UPDATE current_timestamp',
        ], $tableOptions);

        $this->createIndex('idx-address_creator_user_id', '{{%address}}', 'creator_user_id');
        $this->addForeignKey('fk-address_creator_user_id', '{{%address}}', 'creator_user_id' ,'user', 'id', 'NO ACTION');
        $this->createIndex('idx-address_modyfy_user_id', '{{%address}}', 'modyfy_user_id');
        $this->addForeignKey('fk-address_modyfy_user_id', '{{%address}}', 'modyfy_user_id' ,'user', 'id', 'NO ACTION');
    }



    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-address_creator_user_id', 'address');
        $this->dropIndex('idx-address_creator_user_id', 'address');
        $this->dropForeignKey('fk-address_modyfy_user_id', 'address');
        $this->dropIndex('idx-address_modyfy_user_id', 'address');

        $this->dropTable('address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180818_141515_adress_table cannot be reverted.\n";

        return false;
    }
    */
}
