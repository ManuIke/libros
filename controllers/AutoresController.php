<?php

namespace app\controllers;

use app\models\Autores;
use app\models\Libros;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AutoresController extends Controller
{
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
            'pagination' => [
                'pageSize' => 2,
            ],
            'sort' => [
                'attributes' => [
                    'nombre' => [
                        'asc' => ['nombre' => SORT_ASC],
                        'desc' => ['nombre' => SORT_DESC],
                        'label' => 'Nombre',
                    ],
                ],
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $autor = $this->findAutor($id);
        $libros = (new Query())
            ->from('libros')
            ->where(['autor_id' => $id]);
    
        $dataProvider = new ActiveDataProvider([
            'query' => $libros,
            'pagination' => false,
            'sort' => [
                'attributes' => [
                    'isbn' => [
                        'asc' => ['isbn' => SORT_ASC],
                        'desc' => ['isbn' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'ISBN',
                    ],
                    'titulo' => [
                        'label' => 'Título',
                    ],
                    'anyo' => [
                        'label' => 'Año',
                    ],
                ],
            ]
        ]);

        return $this->render('view', [
            'autor' => $autor,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $autor = $this->findAutor($id);

        if ($autor->getLibros()->exists()) {
            Yii::$app->session->setFlash('error', 'El autor tiene libros asociados.');
        } else {
            $autor->delete();
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

    private function findAutor($id)
    {
        $autor = Autores::findOne($id);

        if ($autor === null) {
            throw new NotFoundHttpException('Ese autor no existe.');
        }

        return $autor;
    }
}