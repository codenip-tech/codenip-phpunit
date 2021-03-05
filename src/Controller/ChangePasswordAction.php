<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\ChangePasswordRequest;
use App\Service\ChangePasswordActionService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChangePasswordAction
{
    public function __construct(private ChangePasswordActionService $changePasswordActionService)
    {
    }

    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $this->changePasswordActionService->__invoke($request->getId(), $request->getCurrentPassword(), $request->getNewPassword());

        return new JsonResponse(['status' => 'Password has been changed!']);
    }
}
