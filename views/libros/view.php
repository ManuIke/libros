<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = 'Detalle del libro ' . Html::encode($libro['titulo']);
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['libros/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= DetailView::widget([
    'model' => $libro,
    'attributes' => [
        'isbn',
        'titulo',
        'anyo',
    ],
]) ?>

<h3>Autores</h3>

<div id="lista-autores">
    <?= $this->render('_lista-autores', [
        'dataProviderAutoresLibros' => $dataProviderAutoresLibros,
    ]) ?>
</div>

<?= $this->render('_form-agregar-autores', [
    'autoresLibros' => $autoresLibros,
    'libro' => $libro,
    'listaAutores' => $listaAutores,
]) ?>