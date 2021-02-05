<?php

use yii\helpers\Html;
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
        [
            'attribute' => 'autor.nombre',
            'label' => 'Autor',
        ],
    ],
]) ?>
