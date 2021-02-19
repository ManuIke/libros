<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pendientes}}`.
 */
class m210219_171016_create_pendientes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pendientes}}', [
            'id' => $this->bigInteger(),
            'created_at' => $this->timestamp(0)->defaultExpression('LOCALTIMESTAMP'),
            'token' => $this->string(255),
        ]);

        $this->addPrimaryKey('pk_pendientes', 'pendientes', 'id');
        $this->addForeignKey(
            'fk_pendientes_usuarios',
            'pendientes',
            'id',
            'usuarios',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_pendientes_usuarios', 'pendientes');
        $this->dropTable('{{%pendientes}}');
    }
}
