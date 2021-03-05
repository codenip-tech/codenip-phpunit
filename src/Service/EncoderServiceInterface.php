<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;

interface EncoderServiceInterface
{
    public function generateEncodedPasswordForUser(UserInterface $user, string $password): string;

    public function checkIfValidPassword(UserInterface $user, string $password): bool;
}
