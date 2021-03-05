<?php

declare(strict_types=1);

namespace App\Tests\Functional\Service;

use App\Service\EncoderServiceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncoderServiceMock implements EncoderServiceInterface
{
    public function generateEncodedPasswordForUser(UserInterface $user, string $password): string
    {
        return '';
    }

    public function checkIfValidPassword(UserInterface $user, string $password): bool
    {
        return true;
    }
}
