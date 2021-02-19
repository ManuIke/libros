<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$url = Url::to(['libros/autores-ajax']);

$js = <<<EOT
    $('#libro_id').on('change', function (ev) {
        var libro_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '$url',
            data: {
                libro_id: libro_id
            }
        })
            .done(function (data) {
                $('#lista-autores').html(data);
            });
    });
EOT;
$this->registerJs($js);
?>

<div class="form-group">
    <?= Html::label('Seleccione un libro', 'libro_id') ?>
    <?= Html::dropDownList('libro_id', null, $lista, [
        'class' => 'form-control',
        'id' => 'libro_id',
    ]) ?>
</div>

<div id="lista-autores">
</div>