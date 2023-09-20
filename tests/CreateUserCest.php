<?php
declare(strict_types=1);

use Codeception\Example;
use Codeception\Util\HttpCode;
use Tests\Support\ApiTester;

class CreateUserCest
{
    public function createNewUser(ApiTester $apiTester): void
    {
        $apiTester->wantToTest('Create new user');

        $requestBody = [
            'name' => "asdgas",
            'data' => [
                'email' => 'asadsaaggdssssa@gmail.com',
                'position' => 'dfdsggf',
                'age' => 29
            ]
        ];
        foreach($requestBody as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo 'The Email Format is Valid';
            } else {
                echo 'Invalid Email Format';
            }
        }


        /* function contains($str, array $requestBody): void
        {
            foreach($requestBody as $email) {
                if (str_contains($email, '@'. '.')) {
                } else{
                    echo 'неверный email';

                }
            }

        }*/


        $apiTester->sendPostAsJson('', $requestBody);

        $apiTester->seeResponseCodeIs(HttpCode::OK);

        $apiTester->seeResponseIsJson();

        $apiTester->seeResponseMatchesJsonType(
            [
                'id' => 'string',
                'name' => 'string',
                'data' => [
                    'email' => 'string',
                    'position' => 'string',
                    'age' => 'integer'
                ]
            ]

        );
    }

    /** @dataProvider incorrectDataProvider */
    public function createGameWithIncorrectData(ApiTester $apiTester, Example $provider): void
    {
        $apiTester->wantToTest('Create new user with incorrect data');

        $apiTester->sendPostAsJson('', $provider['requestBody']);

        $apiTester->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    private function incorrectDataProvider(): iterable
    {
        yield [
            'requestBody' => [],
        ];

        yield [
            'requestBody' => '-1'
        ];
    }


}