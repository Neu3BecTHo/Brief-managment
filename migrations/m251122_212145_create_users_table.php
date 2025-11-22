<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m251122_212145_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(4),

            'username' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'phone' => $this->string(20)->notNull()->unique(),

            'first_name' => $this->string(50)->notNull(),
            'last_name' => $this->string(50)->notNull(),
            'patronymic' => $this->string(50),

            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull(),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
