<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$urlIsbn = Url::to(['prestamos/buscar-isbn-ajax']);

$js = <<<EOT
    $('#isbn').blur(function (ev) {
        var isbn = $(this).val();
        $.ajax({
            type: 'GET',
            url: '$urlIsbn',
            data: {
                isbn: isbn
            }
        })
            .done(function (data) {
                if (data.encontrado) {
                    $('#titulo').html(data.titulo);
                    $('#titulo').removeClass('text-danger');
                } else {
                    $('#titulo').html('Error: el libro no existe');
                    $('#titulo').addClass('text-danger');
                }
            });
    });
EOT;
$this->registerJs($js);
?>

<h3>Préstamos pendientes</h3>

<?= $this->render('_pendientes', [
    'prestamosPendientes' => $prestamosPendientes,
]) ?>

<h3>Prestar un libro</h3>

<div id="formulario">
    <div class="form-group">
        <?= Html::label('ISBN', 'isbn') ?>
        <?= Html::textInput('isbn', '', [
            'class' => 'form-control',
            'id' => 'isbn',
        ]) ?>
    </div>
    <?= Html::label('', '', [
        'id' => 'titulo',
    ]) ?>
</div>
