<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Crear un nuevo autor';
$this->params['breadcrumbs'][] = [
    'label' => 'Autores',
    'url' => ['autores/index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($autor, 'nombre') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>