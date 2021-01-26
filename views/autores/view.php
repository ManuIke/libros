<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;

$this->title = 'Detalle del autor ' . Html::encode($autor['nombre']);
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['autores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Autor</h3>
<p><?= Html::encode($autor['nombre']) ?></p>

<table class="table">
    <thead>
        <th><?= $sort->link('isbn') ?></th>
        <th><?= $sort->link('titulo') ?></th>
        <th><?= $sort->link('anyo') ?></th>
    </thead>
    <tbody>
        <?php foreach ($libros->each() as $libro): ?>
            <tr>
                <td><?= Html::encode($libro['isbn']) ?></td>
                <td><?= Html::encode($libro['titulo']) ?></td>
                <td><?= Html::encode($libro['anyo']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
