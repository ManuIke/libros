<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'nombre',
    ],
]) ?>

<?= Html::a(
    'Crear un nuevo autor',
    ['autores/create'],
    ['class' => 'btn btn-info']
) ?>