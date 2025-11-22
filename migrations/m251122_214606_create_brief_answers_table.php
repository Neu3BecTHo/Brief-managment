<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brief_answers}}`.
 */
class m251122_214606_create_brief_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brief_answers}}', [
            'id' => $this->primaryKey(3),
            'brief_question_id' => $this->integer(3)->notNull(),
            'user_id' => $this->integer(4)->notNull(),

            'answer' => $this->text()->notNull(),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_brief_answers_brief_question_id', '{{%brief_answers}}', 'brief_question_id', '{{%brief_questions}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_brief_answers_user_id', '{{%brief_answers}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_brief_answers_brief_question_id', '{{%brief_answers}}', 'brief_question_id');
        $this->createIndex('idx_brief_answers_user_id', '{{%brief_answers}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_brief_answers_brief_question_id', '{{%brief_answers}}');
        $this->dropForeignKey('fk_brief_answers_user_id', '{{%brief_answers}}');

        $this->dropIndex('idx_brief_answers_brief_question_id', '{{%brief_answers}}');
        $this->dropIndex('idx_brief_answers_user_id', '{{%brief_answers}}');

        $this->dropTable('{{%brief_answers}}');
    }
}
