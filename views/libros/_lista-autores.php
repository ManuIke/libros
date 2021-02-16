<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

?>

<?= GridView::widget([
    'dataProvider' => $dataProviderAutoresLibros,
    'columns' => [
        'autor.nombre',
        'autor.fechanac:date',
        [
            '__class' => ActionColumn::class,
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a(
                        'Quitar',
                        [
                            'libros/borrar-autor',
                            'autor_id' => $key['autor_id'],
                            'libro_id' => $key['libro_id'],
                        ],
                        [
                            'class' => 'btn-sm btn-danger quitar',
                            'data-method' => 'POST',
                            'data-confirm' => '¿Está seguro?',
                        ],
                    );
                }
            ],
        ],
    ],
]) ?>
