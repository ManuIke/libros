<?php

use yii\db\Migration;

/**
 * Class m210212_164346_alter_autores_libros_table
 */
class m210212_164346_alter_autores_libros_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand('ALTER TABLE autores_libros
                                      RENAME COLUMN autores_id TO autor_id')
            ->execute();
        Yii::$app->db->createCommand('ALTER TABLE autores_libros
                                      RENAME COLUMN libros_id TO libro_id')
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand('ALTER TABLE autores_libros
                                      RENAME COLUMN autor_id TO autores_id')
            ->execute();
        Yii::$app->db->createCommand('ALTER TABLE autores_libros
                                      RENAME COLUMN libro_id TO libros_id')
            ->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210212_164346_alter_autores_libros_table cannot be reverted.\n";

        return false;
    }
    */
}
