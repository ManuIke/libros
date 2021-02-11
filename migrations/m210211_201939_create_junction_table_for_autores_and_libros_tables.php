<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%autores_libros}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%autores}}`
 * - `{{%libros}}`
 */
class m210211_201939_create_junction_table_for_autores_and_libros_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autores_libros}}', [
            'autores_id' => $this->bigInteger(),
            'libros_id' => $this->bigInteger(),
            'PRIMARY KEY(autores_id, libros_id)',
        ]);

        // creates index for column `autores_id`
        $this->createIndex(
            '{{%idx-autores_libros-autores_id}}',
            '{{%autores_libros}}',
            'autores_id'
        );

        // add foreign key for table `{{%autores}}`
        $this->addForeignKey(
            '{{%fk-autores_libros-autores_id}}',
            '{{%autores_libros}}',
            'autores_id',
            '{{%autores}}',
            'id',
            'CASCADE'
        );

        // creates index for column `libros_id`
        $this->createIndex(
            '{{%idx-autores_libros-libros_id}}',
            '{{%autores_libros}}',
            'libros_id'
        );

        // add foreign key for table `{{%libros}}`
        $this->addForeignKey(
            '{{%fk-autores_libros-libros_id}}',
            '{{%autores_libros}}',
            'libros_id',
            '{{%libros}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%autores}}`
        $this->dropForeignKey(
            '{{%fk-autores_libros-autores_id}}',
            '{{%autores_libros}}'
        );

        // drops index for column `autores_id`
        $this->dropIndex(
            '{{%idx-autores_libros-autores_id}}',
            '{{%autores_libros}}'
        );

        // drops foreign key for table `{{%libros}}`
        $this->dropForeignKey(
            '{{%fk-autores_libros-libros_id}}',
            '{{%autores_libros}}'
        );

        // drops index for column `libros_id`
        $this->dropIndex(
            '{{%idx-autores_libros-libros_id}}',
            '{{%autores_libros}}'
        );

        $this->dropTable('{{%autores_libros}}');
    }
}
