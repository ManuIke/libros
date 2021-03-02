<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prestamos}}`.
 */
class m210302_190133_create_prestamos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prestamos}}', [
            'id' => $this->bigPrimaryKey(),
            'libro_id' => $this->bigInteger()->notNull(),
            'usuario_id' => $this->bigInteger()->notNull(),
            'created_at' => $this->timestamp(0)->notNull()->defaultExpression('LOCALTIMESTAMP'),
            'devolucion' => $this->timestamp(0),
        ]);

        $this->addForeignKey(
            'fk_prestamos_libros',
            'prestamos',
            'libro_id',
            'libros',
            'id'
        );

        $this->addForeignKey(
            'fk_prestamos_usuarios',
            'prestamos',
            'usuario_id',
            'usuarios',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_prestamos_libros', 'prestamos');
        $this->dropForeignKey('fk_prestamos_usuarios', 'prestamos');
        $this->dropTable('{{%prestamos}}');
    }
}
