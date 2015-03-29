<?php 
$I = new ApiTester($scenario);

$I->wantTo('GET logs by id: /api/v1/logs/1');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'stanisov@gmail.com', 'password' => 'stanisov@gmail.com']);
$auth = $I->grabDataFromJsonResponse();

$I->amBearerAuthenticated($auth['data'][0]['token']);

$I->sendGET('api/v1/logs/1');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();