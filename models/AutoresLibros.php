<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "autores_libros".
 *
 * @property int $autor_id
 * @property int $libro_id
 *
 * @property Autores $autor
 * @property Libros $libro
 */
class AutoresLibros extends \yii\db\ActiveRecord
{
    const SCENARIO_LIBROS_VIEW = 'libros/view';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autores_libros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['autor_id', 'libro_id'], 'required'],
            [['autor_id', 'libro_id'], 'default', 'value' => null],
            [['autor_id', 'libro_id'], 'integer'],
            [['autor_id', 'libro_id'], 'unique', 'targetAttribute' => ['autor_id', 'libro_id']],
            [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Autores::class, 'targetAttribute' => ['autor_id' => 'id']],
            [['libro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::class, 'targetAttribute' => ['libro_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_LIBROS_VIEW => [
                'autor_id',
                '!libro_id',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'autor_id' => 'Autores ID',
            'libro_id' => 'Libros ID',
        ];
    }

    /**
     * Gets query for [[Autores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(Autores::class, ['id' => 'autor_id'])
            ->inverseOf('autoresLibros');
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::class, ['id' => 'libro_id'])
            ->inverseOf('autoresLibros');
    }
}
