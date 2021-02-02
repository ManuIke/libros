<?php

namespace app\controllers;

use app\models\Libros;
use app\models\LibrosForm;
use app\models\LibrosSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\Query;
use yii\web\Controller;

class LibrosController extends Controller
{
    public function actionCreate()
    {
        $librosForm = new LibrosForm();

        if ($librosForm->load(Yii::$app->request->post()) && $librosForm->validate()) {
            return $this->redirect(['site/index']);
        }

        return $this->render('create', [
            'librosForm' => $librosForm,
        ]);
    }

    /*
    CRUD:

       - index: visualizar todas las filas de la tabla
       - create: dar de alta
       - update: modificar
       - delete: borrar
       - view:   ver una fila
    */

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Libros::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
