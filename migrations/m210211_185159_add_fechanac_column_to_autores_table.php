<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%autores}}`.
 */
class m210211_185159_add_fechanac_column_to_autores_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autores}}', 'fechanac', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%autores}}', 'fechanac');
    }
}
