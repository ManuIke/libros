<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'libros-create',
]) ?>

    <?= $form->field($libro, 'isbn', ['enableAjaxValidation' => true]) ?>
    <?= $form->field($libro, 'titulo') ?>
    <?= $form->field($libro, 'anyo') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>