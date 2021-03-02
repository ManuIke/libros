<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestamos".
 *
 * @property int $id
 * @property int $libro_id
 * @property int $usuario_id
 * @property string $created_at
 * @property string|null $devolucion
 *
 * @property Libros $libro
 * @property Usuarios $usuario
 */
class Prestamos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestamos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['libro_id', 'usuario_id'], 'required'],
            [['libro_id', 'usuario_id', 'created_at', 'devolucion'], 'default', 'value' => null],
            [['libro_id', 'usuario_id'], 'integer'],
            [['created_at', 'devolucion'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['libro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::class, 'targetAttribute' => ['libro_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'libro_id' => 'Libro',
            'usuario_id' => 'Usuario',
            'created_at' => 'Fecha préstamo',
            'devolucion' => 'Fecha devolución',
        ];
    }

    /**
     * Gets query for [[Libro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::class, ['id' => 'libro_id'])
            ->inverseOf('prestamos');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])
            ->inverseOf('prestamos');
    }
}
