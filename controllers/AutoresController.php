<?php

namespace app\controllers;

use yii\db\Query;
use yii\web\Controller;

class AutoresController extends Controller
{
    public function actionIndex()
    {
        $autores = (new Query())->from('autores')->all();

        return $this->render('index', [
            'autores' => $autores,
        ]);
    }

    public function actionView($id)
    {
        $autor = (new Query())
            ->from('autores')
            ->where(['id' => $id])
            ->one();
    
        return $this->render('view', [
            'autor' => $autor,
        ]);
    }    
}