<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;

?>

<table class="table">
    <thead>
        <th><?= $sort->link('nombre') ?></th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php foreach ($autores as $autor): ?>
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
    'pagination' => $pagination,
]) ?>