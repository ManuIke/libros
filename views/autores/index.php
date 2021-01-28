<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'nombre',
        [
            'label' => 'Acciones',
            'value' => function ($model, $key, $index, $column) {
                return Html::a('Ver', [
                    'autores/view',
                    'id' => $model['id'],
                ], ['class' => 'btn btn-sm btn-info']);
            },
            'format' => 'html',
        ],
    ],
]) ?>