<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = 'Listado de libros';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => ['libros/index'],
]) ?>
    <?= $form->field($librosSearch, 'isbn') ?>
    <?= $form->field($librosSearch, 'titulo') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>

<table class="table">
    <thead>
        <th><?= $sort->link('isbn') ?></th>
        <th><?= $sort->link('titulo') ?></th>
        <th><?= $sort->link('anyo') ?></th>
    </thead>
    <tbody>
        <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?= Html::encode($libro['isbn']) ?></td>
                <td><?= Html::encode($libro['titulo']) ?></td>
                <td><?= Html::encode($libro['anyo']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div>
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>
</div>