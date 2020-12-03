<?php 

class IndexCest
{
    public function index(ApiTester $I)
    {
        $I->sendGet('/');
        $I->seeResponseCodeIs(200);
    }
}
