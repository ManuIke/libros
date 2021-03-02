<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$urlDevolver = Url::to(['prestamos/devolver-ajax']);
$js = <<<EOT
    $('.devolver').click(function (ev) {
        var el = $(this);
        var key = el.data('key');
        $.ajax({
            type: 'POST',
            url: '$urlDevolver',
            data: {
                id: key
            }
        })
            .done(function (data) {
                $('#pendientes').html(data);
            });
    });
EOT;
$this->registerJs($js);

?>

<div id="pendientes">
    <?= GridView::widget([
        'dataProvider' => $prestamosPendientes,
        'columns' => [
            'libro.titulo',
            'usuario.nombre',
            'created_at:datetime',
            [
                '__class' => ActionColumn::class,
                'template' => '{devolver}',
                'buttons' => [
                    'devolver' => function ($url, $model, $key) {
                        return Html::button('Devolver', [
                            'class' => 'btn btn-sm btn-info devolver',
                            'data-key' => $key,
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
