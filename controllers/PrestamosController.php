<?php

namespace app\controllers;

use app\models\Prestamos;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class PrestamosController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'prestamosPendientes' => $this->pendientes(),
        ]);
    }

    public function actionDevolverAjax()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $prestamo = Prestamos::findOne($id);
            $prestamo->devolucion = date('Y-m-d H:i:s');
            $prestamo->save();
            return $this->renderAjax('_pendientes', [
                'prestamosPendientes' => $this->pendientes(),
            ]);
        }
    }

    /**
     * @return ActiveDataProvider
     */
    private function pendientes()
    {
        $query = Prestamos::find()
            ->where([
                'usuario_id' => Yii::$app->user->id,
                'devolucion' => null,
            ]);

        $prestamosPendientes = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $prestamosPendientes;
    }
}
