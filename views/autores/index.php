<?php

use yii\bootstrap4\LinkPager;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;

?>

<table class="table">
    <thead>
        <th><?= $dataProvider->sort->link('nombre') ?></th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->getModels() as $autor): ?>
            <tr>
                <td><?= Html::encode($autor['nombre']) ?></td>
                <td>
                    <?= Html::a('Ver', [
                        'autores/view',
                        'id' => $autor['id'],
                    ], ['class' => 'btn btn-sm btn-info']) ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= LinkPager::widget([
    'pagination' => $dataProvider->pagination,
]) ?>

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