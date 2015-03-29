<?php 
$I = new ApiTester($scenario);

$I->wantTo('GET users list: /api/v1/users');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/auth', ['login' => 'stanisov@gmail.com', 'password' => 'stanisov@gmail.com']);
$auth = $I->grabDataFromJsonResponse();

$I->amBearerAuthenticated($auth['data'][0]['token']);

$I->sendGET('api/v1/users');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET,POST,PUT');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data[0]user_id');
$I->seeResponseJsonMatchesJsonPath('$.data[0]token');
$I->seeResponseJsonMatchesJsonPath('$.data[0]expire_date');