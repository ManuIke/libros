<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$url = Url::to(['libros/agregar-autor-ajax']);
$libro_id = $libro->id;
$js = <<<EOT
    $('#agregar-autor').on('beforeSubmit', function (ev) {
        var form = $(this);
        var autor_id = $('#autoreslibros-autor_id').val();
        $.ajax({
            type: 'POST',
            url: '$url',
            data: {
                AutoresLibros: {
                    libro_id: $libro_id,
                    autor_id: autor_id
                }
            }
        })
            .done(function(data) {
                if(data.success) {
                    // data is saved
                    $('#lista-autores').html(data.respuesta);
                    $('option[value="' + autor_id + '"]').remove();
                } else if (data.validation) {
                    // server validation failed
                    form.yiiActiveForm('updateMessages', data.validation, true); // renders validation messages at appropriate places
                } else {
                    // incorrect server response
                }
            })
            .fail(function () {
                // request failed
            });

        return false;
    });
EOT;
$this->registerJs($js);
?>

<?php $form = ActiveForm::begin([
    'id' => 'agregar-autor',
    'enableAjaxValidation' => true,
]) ?>
    <?= $form->field($autoresLibros, 'autor_id')
        ->dropDownList($listaAutores) ?>

    <div class="form-group">
        <?= Html::submitButton('Añadir', [
            'class' => 'btn btn-success',
            'id' => 'enviar',
        ]) ?>
    </div>
<?php ActiveForm::end() ?>