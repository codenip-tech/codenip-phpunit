<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class GetUserActionService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(string $email): User
    {
        return $this->userRepository->byEmailOrFail($email);
    }
}
