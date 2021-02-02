<?php

use yii\grid\GridView;

$this->title = 'Listado de libros';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'isbn',
        'titulo',
        'anyo',
        'autor.nombre',
    ],
]) ?>