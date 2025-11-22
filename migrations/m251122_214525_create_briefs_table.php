<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%briefs}}`.
 */
class m251122_214525_create_briefs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%briefs}}', [
            'id' => $this->primaryKey(3),
            'user_id' => $this->integer(4)->notNull(),
            'status_id' => $this->integer(2)->notNull(),

            'title' => $this->string(50)->notNull()->unique(),
            'description' => $this->text()->notNull(),
            
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_briefs_user_id', '{{%briefs}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_briefs_status_id', '{{%briefs}}', 'status_id', '{{%statuses}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_briefs_user_id', '{{%briefs}}', 'user_id');
        $this->createIndex('idx_briefs_status_id', '{{%briefs}}', 'status_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_briefs_user_id', '{{%briefs}}');
        $this->dropForeignKey('fk_briefs_status_id', '{{%briefs}}');

        $this->dropIndex('idx_briefs_user_id', '{{%briefs}}');
        $this->dropIndex('idx_briefs_status_id', '{{%briefs}}');

        $this->dropTable('{{%briefs}}');
    }
}
