<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('check welcome message');
$I->amOnPage('/');
$I->see('Welcome');
