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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%type_fields}}');
    }
}
