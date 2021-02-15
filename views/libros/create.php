<?php
$this->title = 'Crear un nuevo libro';
$this->params['breadcrumbs'][] = [
    'label' => 'Libros',
    'url' => ['libros/index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'libro' => $libro,
]) ?>