<?php

namespace app\controllers;

use yii\data\Pagination;
use yii\data\Sort;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AutoresController extends Controller
{
    public function actionIndex()
    {
        $autores = (new Query())->from('autores');

        $pagination = new Pagination([
            'pageSize' => 2,
            'totalCount' => $autores->count(),
        ]);

        $sort = new Sort([
            'attributes' => [
                'nombre' => [
                    'asc' => ['nombre' => SORT_ASC],
                    'desc' => ['nombre' => SORT_DESC],
                    'label' => 'Nombre',
                ],
            ],
        ]);

        $autores->limit($pagination->limit)->offset($pagination->offset);
        $autores->orderBy($sort->orders);

        return $this->render('index', [
            'autores' => $autores->all(),
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
    }

    public function actionView($id)
    {
        $autor = $this->findAutor($id);
        $libros = (new Query())
            ->from('libros')
            ->where(['autor_id' => $id]);
    
        $sort = new Sort([
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
        ]);

        $libros->orderBy($sort->orders);

        return $this->render('view', [
            'autor' => $autor,
            'libros' => $libros,
            'sort' => $sort,
        ]);
    }

    private function findAutor($id)
    {
        $autor = (new Query())
            ->from('autores')
            ->where(['id' => $id])
            ->one();

        if ($autor === false) {
            throw new NotFoundHttpException('Ese autor no existe.');
        }

        return $autor;
    }
}