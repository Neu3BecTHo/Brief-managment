<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brief_questions}}`.
 */
class m251122_214548_create_brief_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brief_questions}}', [
            'id' => $this->primaryKey(3),
            'brief_id' => $this->integer(3)->notNull(),
            'type_field_id' => $this->integer(2)->notNull(),

            'question' => $this->string(255)->notNull(),
            'options' => $this->text()->null(),
            'is_required' => $this->boolean()->notNull()->defaultValue(false),
            'sort_order' => $this->integer(3)->notNull()->defaultValue(0),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_brief_questions_brief_id', '{{%brief_questions}}', 'brief_id', '{{%briefs}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_brief_questions_type_field_id', '{{%brief_questions}}', 'type_field_id', '{{%type_fields}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_brief_questions_brief_id', '{{%brief_questions}}', 'brief_id');
        $this->createIndex('idx_brief_questions_type_field_id', '{{%brief_questions}}', 'type_field_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_brief_questions_brief_id', '{{%brief_questions}}');
        $this->dropForeignKey('fk_brief_questions_type_field_id', '{{%brief_questions}}');

        $this->dropIndex('idx_brief_questions_brief_id', '{{%brief_questions}}');
        $this->dropIndex('idx_brief_questions_type_field_id', '{{%brief_questions}}');

        $this->dropTable('{{%brief_questions}}');
    }
}
