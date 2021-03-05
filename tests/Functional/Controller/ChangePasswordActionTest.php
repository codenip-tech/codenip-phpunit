<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ChangePasswordActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users/%s/change-password';

    public function testChangePasswordAction(): void
    {
        $payload = [
            'currentPassword' => 'sasdgfasdgsdfg',
            'newPassword' => 'new-password',
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, \sprintf(self::ENDPOINT, $this->getPeterId()), [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }
}
