<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Listado de libros';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'columns' => [
        'isbn',
        'titulo',
        'anyo',
        ['__class' => ActionColumn::class],
    ],
]) ?>

<?= Html::a(
    'Crear un nuevo libro',
    ['libros/create'],
    ['class' => 'btn btn-info']
) ?>