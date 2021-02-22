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
     */
    public function actionBorrarDesactivados()
    {
        $numero = Usuarios::deleteAll([
            'id' => Pendientes::find()
                ->select('id')
                ->where("created_at + '2 days' < LOCALTIMESTAMP")
        ]);

        echo "Se han borrado $numero filas.\n";

        return ExitCode::OK;
    }
}