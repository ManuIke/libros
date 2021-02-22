<?php

namespace app\commands;

use app\models\Pendientes;
use app\models\Usuarios;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Comandos relacionados con los usuarios.
 */
class UsuariosController extends Controller
{
    /**
     * Borra los usuarios no activados antes de 48 horas.
     * 
     * @param int $dias Número máximo de días para activar la cuenta.
     */
    public function actionBorrarDesactivados(int $dias = 2)
    {
        $numero = Usuarios::deleteAll([
            'id' => Pendientes::find()
                ->select('id')
                ->where("created_at + '$dias days' < LOCALTIMESTAMP")
        ]);

        echo "Se han borrado $numero filas.\n";

        return ExitCode::OK;
    }
}