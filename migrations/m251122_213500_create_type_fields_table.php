<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%type_fields}}`.
 */
class m251122_213500_create_type_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%type_fields}}', [
            'id' => $this->primaryKey(2),

            'title' => $this->string(50)->notNull()->unique(),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->batchInsert('{{%type_fields}}', ['id', 'title'], [
            [1, 'text'],
            [2, 'number'],
            [3, 'select'],
            [4, 'radio'],
            [5, 'checkbox'],
            [6, 'textarea'],
            [7, 'date'],
            [8, 'email'],
            [9, 'phone'],
            [10, 'color'],
            [11, 'comment'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%type_fields}}');
    }
}
