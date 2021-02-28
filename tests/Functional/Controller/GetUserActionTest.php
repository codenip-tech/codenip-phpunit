<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\FunctionalTestBase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetUserActionTest extends FunctionalTestBase
{
    use RecreateDatabaseTrait;

    private const ENDPOINT = '/api/v1/users';

    public function testGetUserByEmail(): void
    {
        self::$authenticatedClient->request(Request::METHOD_GET, \sprintf('%s?email=peter@api.com', self::ENDPOINT));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertEquals('Peter', $responseData['user']['name']);
    }

    public function testGetUserForNonExistingEmail(): void
    {
        self::$authenticatedClient->request(Request::METHOD_GET, \sprintf('%s?email=brian@api.com', self::ENDPOINT));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
