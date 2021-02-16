<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = 'Detalle del libro ' . Html::encode($libro['titulo']);
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['libros/index']];
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['libros/agregar-autor-ajax']);
$urlQuitar = Url::to(['libros/borrar-autor-ajax']);

$libro_id = $libro->id;
$js = <<<EOT
    $('.quitar').on('click', function (ev) {
        var tr = $(this).closest('tr');
        var key = tr.data('key');
        var autor_id = key.autor_id;
        var libro_id = key.libro_id;
        $.ajax({
            type: 'POST',
            url: '$urlQuitar',
            data: {
                libro_id: libro_id,
                autor_id: autor_id
            }
        })
            .done(function (data) {
                $('#lista-autores').html(data);
            });
    });

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
            // .done(function (data) {
            //     $('#lista-autores').html(data);
            // });

        return false;
    });
EOT;
$this->registerJs($js);
?>

<?= DetailView::widget([
    'model' => $libro,
    'attributes' => [
        'isbn',
        'titulo',
        'anyo',
    ],
]) ?>

<h3>Autores</h3>

<div id="lista-autores">
    <?= $this->render('_lista-autores', [
        'dataProviderAutoresLibros' => $dataProviderAutoresLibros,
    ]) ?>
</div>

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