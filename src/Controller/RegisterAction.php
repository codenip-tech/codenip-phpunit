<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\RegisterRequest;
use App\Service\RegisterActionService;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterAction
{
    public function __construct(private RegisterActionService $registerActionService)
    {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        return new JsonResponse(['token' => $this->registerActionService->__invoke($request)]);
    }
}
