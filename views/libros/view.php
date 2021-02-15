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
                            'class' => 'btn-sm btn-danger',
                            'data-method' => 'POST',
                            'data-confirm' => '¿Está seguro?',
                        ],
                    );
                }
            ],
        ],
    ],
]) ?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($autoresLibros, 'autor_id')
        ->dropDownList($listaAutores) ?>

    <div class="form-group">
        <?= Html::submitButton('Añadir', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end() ?>