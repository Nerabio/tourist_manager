<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180801_063940_create_user_table extends Migration
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

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'role' => $this->smallInteger()->notNull()->defaultValue(0),
            'creator_user_id' => $this->integer()->defaultValue(null),
            'modyfy_user_id' => $this->integer()->defaultValue(null),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('idx-user-username', '{{%user}}', 'username');
        $this->createIndex('idx-user-email', '{{%user}}', 'email');
        $this->createIndex('idx-user-phone', '{{%user}}', 'phone');
        $this->createIndex('idx-user-status', '{{%user}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user-username', 'user');
        $this->dropIndex('idx-user-email', 'user');
        $this->dropIndex('idx-user-phone', 'user');
        $this->dropIndex('idx-user-status', 'user');

        $this->dropTable('user');
    }
}
