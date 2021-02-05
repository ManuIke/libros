<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($libro, 'isbn') ?>
    <?= $form->field($libro, 'titulo') ?>
    <?= $form->field($libro, 'anyo') ?>
    <?= $form->field($libro, 'autor_id')->dropDownList($listaAutores) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>