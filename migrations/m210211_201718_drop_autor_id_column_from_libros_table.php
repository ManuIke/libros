<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%libros}}`.
 */
class m210211_201718_drop_autor_id_column_from_libros_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%libros}}', 'autor_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%libros}}', 'autor_id', $this->bigint());
    }
}
