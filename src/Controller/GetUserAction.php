<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\GetUserRequest;
use App\Service\GetUserActionService;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserAction
{
    public function __construct(private GetUserActionService $getUserActionService)
    {
    }

    public function __invoke(GetUserRequest $request): JsonResponse
    {
        $user = $this->getUserActionService->__invoke($request->getEmail());

        return new JsonResponse(['user' => $user->toArray()]);
    }
}
