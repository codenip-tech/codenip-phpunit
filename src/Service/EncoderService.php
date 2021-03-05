<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncoderService implements EncoderServiceInterface
{
    public function __construct(private UserPasswordEncoderInterface $userPasswordEncoder)
    {
    }

    public function generateEncodedPasswordForUser(UserInterface $user, string $password): string
    {
        return $this->userPasswordEncoder->encodePassword($user, $password);
    }

    public function checkIfValidPassword(UserInterface $user, string $password): bool
    {
        return $this->userPasswordEncoder->isPasswordValid($user, $password);
    }
}
