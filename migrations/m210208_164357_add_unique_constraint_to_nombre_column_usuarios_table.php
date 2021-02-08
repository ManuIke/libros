<?php

use yii\db\Migration;

/**
 * Class m210208_164357_add_unique_constraint_to_nombre_column_usuarios_table
 */
class m210208_164357_add_unique_constraint_to_nombre_column_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand('ALTER TABLE usuarios
                                      ADD CONSTRAINT uq_usuarios_nombre
                                      UNIQUE (nombre)')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand('ALTER TABLE usuarios
                                      DROP CONSTRAINT uq_usuarios_nombre')
            ->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210208_164357_add_unique_constraint_to_nombre_column_usuarios_table cannot be reverted.\n";

        return false;
    }
    */
}
