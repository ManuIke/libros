<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendientes".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $token
 *
 * @property Usuarios $usuario
 */
class Pendientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['token'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'token' => 'Token',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id'])
            ->inverseOf('pendiente');
    }
}
