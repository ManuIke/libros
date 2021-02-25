<?php

class LibrosCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function abrirCrearUsuario(FunctionalTester $I)
    {
        $I->amOnPage(['libros/create']);
        $I->see('Crear un nuevo libro', 'li');
    }
}
