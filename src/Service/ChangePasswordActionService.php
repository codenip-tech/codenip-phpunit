<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ChangePasswordActionService
{
    public function __construct(
        private EncoderServiceInterface $encoderService,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(string $id, string $currentPassword, string $newPassword): void
    {
        $user = $this->userRepository->byIdOrFail($id);

        if (!$this->encoderService->checkIfValidPassword($user, $currentPassword)) {
            throw new BadRequestHttpException('Invalid current password!');
        }

        $user->setPassword($this->encoderService->generateEncodedPasswordForUser($user, $newPassword));

        $this->userRepository->save($user);
    }
}
