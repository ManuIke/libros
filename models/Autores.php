<?php

namespace app\models;

use yii\db\ActiveRecord;

class Autores extends ActiveRecord
{
    public static function tableName()
    {
        return 'autores';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
        ];
    }

    public function getLibros()
    {
        return $this->hasMany(Libros::class, ['autor_id' => 'id'])
            ->inverseOf('autor');
    }
}