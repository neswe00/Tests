<?php

declare(strict_types=1);



use Codeception\Util\HttpCode;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\Before;
use Tests\Support\ApiTester;

class GetApiTestCest
{

    private string $userId ='123' ;

    #[Before('GetApiTest')]
    public function precondition(ApiTester $apiTester): void
    {
        $requestBody = [
            'name' => "asdas",
            'data' => [
                'email' => 'asadsaadssssa@gmail.com',
                'position' => 'dfdsf',
                'age' => 21
            ]
        ];

        $response = $apiTester->sendPostAsJson('', $requestBody);

        $apiTester->seeResponseCodeIs(HttpCode::OK);


        $this->userId = $response['id'];
    }

    public function getUserById(ApiTester $apiTester): void
    {
        $apiTester->wantToTest('Get user by id');

        $apiTester->sendGet($this->userId);

        $apiTester->seeResponseCodeIs(HttpCode::OK);

        $apiTester->seeResponseIsJson();

        $apiTester->seeResponseContainsJson(
            [
                'id' => $this -> userId,
                'name' => "asdas",
                'data' => [
                    'email' => 'asadsaadssssa@gmail.com',
                    'position' => 'dfdsf',
                    'age' => 21
                ]
            ]
        );
    }


    #[After('GetApiTest')]
    public function postcondition(ApiTester $apiTester): void
    {

        $apiTester->sendDelete($this->userId);

        $apiTester->seeResponseCodeIs(HttpCode::OK);
    }




}