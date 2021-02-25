<?php

namespace app\controllers;

use app\models\CalculadoraForm;
use Yii;
use yii\web\Controller;

class CalculadoraController extends Controller
{
    public function actionCalcular()
    {
        $calculadoraForm = new CalculadoraForm();
        $lista = [
            '+' => '+',
            '-' => '-',
            '*' => '*',
            '/' => '/',
        ];
        $resultado = null;

        if ($calculadoraForm->load(Yii::$app->request->queryParams)
            && $calculadoraForm->validate()) {
            $resultado = $this->calcular(
                $calculadoraForm->op1,
                $calculadoraForm->op2,
                $calculadoraForm->op
            );
            return $this->redirect([
                'calculadora/solucion',
                'resultado' => $resultado,
            ]);
        }

        return $this->render('calcular', [
            'calculadoraForm' => $calculadoraForm,
            'resultado' => $resultado,
            'lista' => $lista,
        ]);
    }

    public function actionSolucion($resultado)
    {
        return $this->render('solucion', [
            'resultado' => $resultado,
        ]);
    }

    private function calcular($op1, $op2, $op)
    {
        switch ($op) {
            case '+':
                $resultado = $op1 + $op2;
                break;
            case '-':
                $resultado = $op1 - $op2;
                break;
            case '*':
                $resultado = $op1 * $op2;
                break;
            case '/':
                $resultado = $op1 / $op2;
                break;
        }
        return $resultado;
    }
}
