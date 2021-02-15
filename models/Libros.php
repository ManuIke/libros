<?php

namespace app\models;

/**
 * This is the model class for table "libros".
 *
 * @property int $id
 * @property string $isbn
 * @property string $titulo
 * @property float|null $anyo
 *
 * @property AutoresLibros[] $autoresLibros
 */
class Libros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isbn', 'titulo'], 'required'],
            [['anyo'], 'number'],
            [['isbn'], 'string', 'max' => 13],
            [['titulo'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'ISBN',
            'titulo' => 'Título',
            'anyo' => 'Año',
        ];
    }

    public function getAutoresLibros()
    {
        return $this->hasMany(AutoresLibros::class, ['libro_id' => 'id'])
            ->inverseOf('libro');
    }

    public function getAutores()
    {
        return $this->hasMany(Autores::class, ['id' => 'autor_id'])
            ->via('autoresLibros');
    }
}