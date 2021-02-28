<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/register';

    public function testRegisterAction(): void
    {
        $payload = [
            'name' => 'Brian',
            'email' => 'brian@api.com',
            'password' => 'password123'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('token', $responseData);
    }

    public function testRegisterActionWithInvalidEmail(): void
    {
        $payload = [
            'name' => 'Brian',
            'email' => 'brian',
            'password' => 'password123'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testRegisterActionWithInvalidPassword(): void
    {
        $payload = [
            'name' => 'Brian',
            'email' => 'brian@api.com',
            'password' => 'pass'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
