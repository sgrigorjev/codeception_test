<?php

use \ApiTester;

class UserCest
{

    public function login(ApiTester $I)
    {
        $I->forgotAll();
        $I->amHttpAuthenticatedAs('userA');
        $I->sendGET('/api/v1/login.php');
        $I->seeResponseCodeIs(202);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesXpath('//username');
        $I->seeResponseJsonMatchesXpath('//role');
        $I->saveCookie('token');
    }

    public function info(ApiTester $I)
    {
        $I->useSavedCookie('token');
        $I->sendGET('/api/v1/user/info.php');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesXpath('//status');
        $I->seeResponseJsonMatchesXpath('//data/username');
    }

    public function info2(ApiTester $I)
    {
        $I->useSavedCookie('token');
        $I->sendGET('/api/v1/user/info.php');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$status');
        $I->seeResponseJsonMatchesJsonPath('$data.username');
    }

    public function userRemainSet(ApiTester $I)
    {
        $I->useSavedCookie('token');
        $I->sendGET('/api/v1/user/remain/set.php');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$status');
        $I->seeResponseJsonMatchesJsonPath('$data.success');
        $I->seeResponseJsonMatchesJsonPath('$data.RemainValue');
        $I->saveCookie('RemainValue');
    }

    public function userRemainGet(ApiTester $I)
    {
        $I->useSavedCookie('token');
        $I->useSavedCookie('RemainValue');
        $I->sendGET('/api/v1/user/remain/get.php');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$status');
        $I->seeResponseJsonMatchesJsonPath('$data.success');
        $I->seeResponseJsonMatchesJsonPath('$data.RemainValue');
    }

}
