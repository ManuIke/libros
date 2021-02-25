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
            [['fechanac'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'fechanac' => 'Fecha de nac.',
        ];
    }

    public function getAutoresLibros()
    {
        return $this->hasMany(AutoresLibros::class, ['autor_id' => 'id'])
            ->inverseOf('autor');
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getLibros()->exists()) {
            return false;
        }
        
        return true;
    }

    public function getLibros()
    {
        return $this->hasMany(Libros::class, ['id' => 'libro_id'])
            ->via('autoresLibros');
    }
}
