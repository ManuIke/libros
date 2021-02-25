<?php

use yii\helpers\Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));        
        $I->see('My Application');
        
        $I->seeLink('Autores');
        $I->click('Autores');
        $I->wait(2); // wait for page to be opened
        
        $I->see('Crear un nuevo autor');
    }
}
