<?php

use yii\db\Migration;

/**
 * Handles the creation of table `favorit_activity`.
 */
class m180809_115656_create_favorit_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favorit_activity', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()->defaultValue(null),
        ]);

        $this->createIndex('idx-favorit_activity_user_id', '{{%favorit_activity}}', 'user_id');
        $this->addForeignKey('fk-favorit_activity_user_id', '{{%favorit_activity}}', 'user_id' ,'user', 'id', 'NO ACTION');
        $this->createIndex('idx-favorit_activity-activity_id', '{{%favorit_activity}}', 'activity_id');
        $this->addForeignKey('fk-favorit_activity-activity_id', '{{%favorit_activity}}', 'activity_id' ,'activity', 'id', 'NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-favorit_activity_user_id', 'favorit_activity');
        $this->dropIndex('idx-favorit_activity_user_id', 'favorit_activity');
        $this->dropForeignKey('fk-favorit_activity-activity_id', 'favorit_activity');
        $this->dropIndex('idx-favorit_activity-activity_id', 'favorit_activity');

        $this->dropTable('favorit_activity');
    }
}
