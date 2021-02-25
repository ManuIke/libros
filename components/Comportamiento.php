<?php

namespace app\components;

use yii\base\Behavior;
use yii\base\Component;

class Comportamiento extends Behavior
{
    public $uno;
    public $dos;
    public $nombre = '';
    public $apellidos = '';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function getNombreCompleto()
    {
        return trim($this->nombre . ' ' . $this->apellidos);
    }

    public function setNombreCompleto($nombreCompleto)
    {
        $array = explode(' ', $nombreCompleto);
        $this->nombre = $array[0];
        $this->apellidos = $array[1];
    }

    public function events()
    {
        return [
            Componente::EVENTO_SALUDA => 'saluda',
        ];
    }

    public function saluda($event)
    {
        echo "Hola\n";
    }
}
