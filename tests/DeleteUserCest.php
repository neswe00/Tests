<?php

declare(strict_types=1);

use Codeception\Example;
use PHPUnit\Framework\Attributes\Before;
use Codeception\Util\HttpCode;
use PHPUnit\Framework\Assert;
use Tests\Support\ApiTester;

class DeleteUserCest
{
    private string $userId='123';

    #[Before('DeleteUserId')]
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

        print_r($this->userId);
    }

    public function deleteUserId(ApiTester $apiTester): void
    {
        $apiTester->wantToTest('Delete game by id');

        $response = $apiTester->sendDelete($this->userId);

        $apiTester->seeResponseCodeIs(HttpCode::OK);

        $responseEntity = json_decode($response, true);

        $message = $responseEntity['message'];

        Assert::assertEquals(
            expected: "Object with id = " . $this->userId . " has been deleted.",
            actual: $message
        );
    }

    /** @dataProvider incorrectDataProvider */
    public function deleteUserWithIncorrectId(ApiTester $apiTester, Example $provider): void
    {
        $apiTester->wantToTest('Delete game by incorrect id');

        $apiTester->sendDelete($provider['incorrectId']);

        $apiTester->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    private function incorrectDataProvider(): iterable
    {
        yield [
            'incorrectId' => 'asd'
        ];

        yield [
            'incorrectId' => '-1'
        ];
    }
}