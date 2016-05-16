<?php

use \AcceptanceTester;

class HelloCest
{

    public function _beforeStep(\Codeception\Step $step)
    {
        file_put_contents('F:/' . mktime() . mt_rand(1, 1000) . '-HelloCest.txt', var_export(1, true));
    }

    public function _before(AcceptanceTester $I)
    {
        
    }

    public function _after(AcceptanceTester $I)
    {
        
    }

    public function helloTest(AcceptanceTester $I)
    {
        $I->wantTo('check hello word');
        $I->amOnPage('/');
        $I->see('Hello');
    }

    public function guestTest(AcceptanceTester $I)
    {
        $I->wantTo('check guest word');
        $I->amOnPage('/');
        $I->see('Guest');
    }

}
