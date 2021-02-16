<?php

namespace app\controllers;

use app\models\Autores;
use app\models\AutoresLibros;
use app\models\Libros;
use app\models\LibrosSearch;
use Yii;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
                    'agregar-autor-ajax' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $libro = new Libros();

        if (Yii::$app->request->isAjax && $libro->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($libro);
        }

        if ($libro->load(Yii::$app->request->post()) && $libro->save()) {
            return $this->redirect(['libros/index']);
        }

        return $this->render('create', [
            'libro' => $libro,
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

        if (Yii::$app->request->isAjax && $autoresLibros->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($autoresLibros);
        }

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

    public function actionAgregarAutorAjax()
    {
        $autoresLibros = new AutoresLibros();

        if (Yii::$app->request->isAjax) {
            if ($autoresLibros->load(Yii::$app->request->post())
                    && $autoresLibros->save()) {
                $libro = $this->findLibro($autoresLibros->libro_id);
                $dataProviderAutoresLibros = new ActiveDataProvider([
                    'query' => $libro->getAutoresLibros(),
                ]);
                $respuesta = $this->renderAjax('_lista-autores', [
                    'dataProviderAutoresLibros' => $dataProviderAutoresLibros,
                ]);
                return $this->asJson([
                    'success' => true,
                    'respuesta' => $respuesta,
                ]);
            }

            $result = [];
            foreach ($autoresLibros->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($autoresLibros, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }
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
}
