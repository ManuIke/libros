<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($fotoForm, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end() ?>
