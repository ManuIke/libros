<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Utilidad extends Component
{
    public static function convertirFormatoFecha($valor) {
        $valor = \DateTime::createFromFormat(
            Yii::$app->params['dateInputFormat'],
            $valor
        );
        return $valor->format(
            Yii::$app->params['dateWorkingFormat']
        );
    }
}