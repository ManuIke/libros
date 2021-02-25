<?php

namespace app\models;

use yii\base\Model;

class CalculadoraForm extends Model
{
    public $op1;
    public $op2;
    public $op;

    public function rules()
    {
        return [
            [['op1', 'op2', 'op'], 'required'],
            [['op1', 'op2'], 'number'],
            [['op'], 'in', 'range' => ['+', '-', '*', '/']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'op1' => 'Primer operando',
            'op2' => 'Segundo operando',
            'op' => 'Operador',
        ];
    }
}
