<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%usuarios}}`.
 */
class m210219_170826_add_email_column_to_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%usuarios}}', 'email', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%usuarios}}', 'email');
    }
}
