<?php

namespace app\controllers;

use app\models\Autores;
use app\models\AutoresLibros;
use app\models\Libros;
use app\models\LibrosSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LibrosController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                '__class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'borrar-autor' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $libro = new Libros();

        if ($libro->load(Yii::$app->request->post()) && $libro->save()) {
            return $this->redirect(['libros/index']);
        }

        return $this->render('create', [
            'libro' => $libro,
            'listaAutores' => $this->listaAutores(),
        ]);
    }

    public function actionUpdate($id)
    {
        $libro = $this->findLibro($id);

        if ($libro->load(Yii::$app->request->post()) && $libro->save()) {
            return $this->redirect(['libros/index']);
        }

        return $this->render('update', [
            'libro' => $libro,
            'listaAutores' => $this->listaAutores(),
        ]);
    }

    public function actionIndex()
    {
        $filterModel = new LibrosSearch();
        $dataProvider = $filterModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
        ]);
    }

    public function actionView($id)
    {
        $libro = $this->findLibro($id);
        $dataProviderAutoresLibros = new ActiveDataProvider([
            'query' => $libro->getAutoresLibros(),
        ]);
        $autoresLibros = new AutoresLibros([
            'scenario' => AutoresLibros::SCENARIO_LIBROS_VIEW,
            'libro_id' => $id,
        ]);
        $listaAutores = Autores::find()
            ->select('nombre')
            ->where(['not in', 'id', $libro->getAutoresLibros()->select('autor_id')])
            ->indexBy('id')
            ->orderBy('nombre')
            ->column();

        if ($autoresLibros->load(Yii::$app->request->post())
            && $autoresLibros->save()) {
            Yii::$app->session->setFlash('success', 'Autor añadido con éxito.');
            return $this->redirect(['libros/view', 'id' => $id]);
        }

        return $this->render('view', [
            'libro' => $libro,
            'dataProviderAutoresLibros' => $dataProviderAutoresLibros,
            'autoresLibros' => $autoresLibros,
            'listaAutores' => $listaAutores,
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->findLibro($id)->delete()) {
            Yii::$app->session->setFlash('success', 'El libro se ha borrado correctamente.');
        }
    }
    
    public function actionBorrarAutor($autor_id, $libro_id)
    {
        $autorLibro = AutoresLibros::findOne([
            'autor_id' => $autor_id,
            'libro_id' => $libro_id,
        ]);

        if ($autorLibro === null) {
            throw new NotFoundHttpException('Esa relación no existe.');
        }

        $autorLibro->delete();
        Yii::$app->session->setFlash('success', 'Se ha quitado ese autor del libro.');

        return $this->redirect(['libros/view', 'id' => $libro_id]);
    }

    private function findLibro($id)
    {
        $libro = Libros::findOne($id);

        if ($libro === null) {
            throw new NotFoundHttpException('Ese libro no existe.');
        }

        return $libro;
    }

    private function listaAutores()
    {
        return Autores::find()->select('nombre')->indexBy('id')->column();
    }

}
