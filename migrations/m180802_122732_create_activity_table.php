<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity`.
 */
class m180802_122732_create_activity_table extends Migration
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

        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status_id' => $this->integer()->defaultValue(0),
            'adress_id' => $this->integer()->defaultValue(null),
            'mark' => $this->string(),
            'color' => $this->string(7),
            'picture_url' => $this->string(),
            'look_counter' => $this->integer()->defaultValue(0),
            'owner_user_id' => $this->integer()->notNull(),
            'creator_user_id' => $this->integer()->defaultValue(null),
            'modyfy_user_id' => $this->integer()->defaultValue(null),
            'date_start' => $this->timestamp()->defaultValue(null),
            'date_end' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('idx-activity-title', '{{%activity}}', 'title');
        $this->createIndex('idx-activity-date_start', '{{%activity}}', 'date_start');
        $this->createIndex('idx-activity-date_end', '{{%activity}}', 'date_end');

        $this->createIndex('idx-activity-owner_user_id', '{{%activity}}', 'owner_user_id');
        $this->addForeignKey('fk-activity-owner_user_id', '{{%activity}}', 'owner_user_id' ,'user', 'id', 'NO ACTION');
        $this->createIndex('idx-activity-creator_user_id', '{{%activity}}', 'creator_user_id');
        $this->addForeignKey('fk-activity-creator_user_id', '{{%activity}}', 'creator_user_id' ,'user', 'id', 'NO ACTION');
        $this->createIndex('idx-activity-modyfy_user_id', '{{%activity}}', 'modyfy_user_id');
        $this->addForeignKey('fk-activity-modyfy_user_id', '{{%activity}}', 'modyfy_user_id' ,'user', 'id', 'NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-activity-title', 'activity');
        $this->dropIndex('idx-activity-owner_user_id', 'activity');
        $this->dropIndex('idx-activity-date_start', 'activity');
        $this->dropIndex('idx-activity-date_end', 'activity');

        $this->dropForeignKey('fk-activity-owner_user_id', 'activity');
        $this->dropIndex('idx-activity-owner_user_id', 'activity');
        $this->dropForeignKey('fk-activity-creator_user_id', 'activity');
        $this->dropIndex('idx-activity-creator_user_id', 'activity');
        $this->dropForeignKey('fk-activity-modyfy_user_id', 'activity');
        $this->dropIndex('idx-activity-modyfy_user_id', 'activity');

        $this->dropTable('activity');
    }
}
