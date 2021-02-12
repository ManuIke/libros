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
            [['isbn', 'titulo', 'autor_id'], 'required'],
            [['anyo'], 'number'],
            [['autor_id'], 'default', 'value' => null],
            [['autor_id'], 'integer'],
            [['isbn'], 'string', 'max' => 13],
            [['titulo'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
            [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Autores::className(), 'targetAttribute' => ['autor_id' => 'id']],
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
            'autor_id' => 'Autor',
        ];
    }

    public function getAutoresLibros()
    {
        return $this->hasMany(AutoresLibros::class, ['libro_id' => 'id'])
            ->inverseOf('libro');
    }
}