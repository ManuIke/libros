<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Detalle del autor ' . Html::encode($autor['nombre']);
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['autores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Autor:</h3>

<?= DetailView::widget([
    'model' => $autor,
    'attributes' => [
        'nombre',
    ],
]) ?>

<h3>Libros del autor:</h3>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'isbn',
            'label' => 'ISBN',
        ],
        [
            'attribute' => 'titulo',
            'label' => 'Título',
        ],
        'anyo',
    ],
]) ?>