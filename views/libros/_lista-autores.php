<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$urlQuitar = Url::to(['libros/borrar-autor-ajax']);
$js = <<<EOT
    $('.quitar').on('click', function (ev) {
        ev.preventDefault();
        var tr = $(this).closest('tr');
        var key = tr.data('key');
        var autor_id = key.autor_id;
        var libro_id = key.libro_id;
        var nombre = tr.find(':first').text();
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
                $('#autoreslibros-autor_id').append($('<option>').attr('value', autor_id).text(nombre));
            });
        return false;
    });
EOT;
$this->registerJs($js);
?>

<?= GridView::widget([
    'dataProvider' => $dataProviderAutoresLibros,
    'columns' => [
        'autor.nombre',
        'autor.fechanac:date',
        [
            '__class' => ActionColumn::class,
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a(
                        'Quitar',
                        [
                            'libros/borrar-autor',
                            'autor_id' => $key['autor_id'],
                            'libro_id' => $key['libro_id'],
                        ],
                        [
                            'class' => 'btn-sm btn-danger quitar',
                            'data-method' => 'POST',
                            'data-confirm' => '¿Está seguro?',
                        ],
                    );
                }
            ],
        ],
    ],
]) ?>
