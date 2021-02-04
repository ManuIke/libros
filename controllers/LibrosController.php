<?php

namespace app\controllers;

use app\models\Libros;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LibrosController extends Controller
{
    public function actionCreate()
    {
        $libro = new Libros();

        if ($libro->load(Yii::$app->request->post()) && $libro->save()) {
            return $this->redirect(['site/index']);
        }

        return $this->render('create', [
            'libro' => $libro,
        ]);
    }

    public function actionUpdate($id)
    {
        $libro = $this->findLibro($id);

        if ($libro->load(Yii::$app->request->post()) && $libro->save()) {
            return $this->redirect(['site/index']);
        }

        return $this->render('update', [
            'libro' => $libro,
        ]);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Libros::find()->with('autor'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $libro = $this->findLibro($id);

        return $this->render('view', [
            'libro' => $libro,
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->findLibro($id)->delete()) {
            Yii::$app->session->setFlash('success', 'El libro se ha borrado correctamente.');
        }
    }
    
    private function findLibro($id)
    {
        $autor = Libros::findOne($id);

        if ($autor === null) {
            throw new NotFoundHttpException('Ese libro no existe.');
        }

        return $autor;
    }
}
