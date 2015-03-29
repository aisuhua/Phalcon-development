<?php
$I = new ApiTester($scenario);

$I->wantTo('GET limit records: /api/v1/logs?limit=5');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'stanisov@gmail.com', 'password' => 'stanisov@gmail.com']);
$auth = $I->grabDataFromJsonResponse();

$I->amBearerAuthenticated($auth['data'][0]['token']);


$I->sendGET('/api/v1/logs?limit=5');

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('limit' => 5));
