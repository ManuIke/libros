<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
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
    'dataProvider' => $dataProviderAutores,
    'columns' => [
        'nombre',
        'fechanac:date',
        [
            '__class' => ActionColumn::class,
            // 'urlCreator' => function (string $action, mixed $model, mixed $key, int $index, ActionColumn $this) {
                
            // }
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