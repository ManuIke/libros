<?php

namespace app\controllers;

use app\models\Autores;
use app\models\Libros;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AutoresController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                '__class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $autor = new Autores();

        if ($autor->load(Yii::$app->request->post()) && $autor->save()) {
            Yii::$app->session->setFlash('success', 'El autor se ha podido crear correctamente.');
            return $this->redirect(['autores/index']);
        }

        return $this->render('create', [
            'autor' => $autor,
        ]);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Autores::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $autor = $this->findAutor($id);
    
        $dataProvider = new ActiveDataProvider([
            'query' => $autor->getLibros(),
            'pagination' => false,
        ]);

        return $this->render('view', [
            'autor' => $autor,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->findAutor($id)->delete()) {
            Yii::$app->session->setFlash('success', 'El autor se ha borrado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'El autor tiene libros asociados.');
        }

        return $this->redirect(['autores/index']);
    }

    public function actionPrueba()
    {
        $libros = Libros::find()->all();

        foreach ($libros as $libro) {
            echo $libro->titulo;
            echo $libro->autor->nombre;
        }

        return $this->render('prueba');
    }

    public function actionUpdate($id)
    {
        $autor = $this->findAutor($id);

        if ($autor->load(Yii::$app->request->post()) && $autor->save()) {
            Yii::$app->session->setFlash('success', 'El autor se ha podido modificar correctamente.');
            return $this->redirect(['autores/index']);
        }

        return $this->render('update', [
            'autor' => $autor,
        ]);
    }

    private function findAutor($id)
    {
        $autor = Autores::findOne($id);

        if ($autor === null) {
            throw new NotFoundHttpException('Ese autor no existe.');
        }

        return $autor;
    }
}
