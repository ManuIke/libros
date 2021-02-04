<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Modificar un nuevo libro';
$this->params['breadcrumbs'][] = [
    'label' => 'Libros',
    'url' => ['libros/index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($libro, 'isbn') ?>
    <?= $form->field($libro, 'titulo') ?>
    <?= $form->field($libro, 'anyo') ?>
    <?= $form->field($libro, 'autor_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>