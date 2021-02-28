<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Http\DTO\RegisterRequest;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterActionService
{
    public function __construct(
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $JWTTokenManager,
        private UserPasswordEncoderInterface $userPasswordEncoder
    ) {
    }

    public function __invoke(RegisterRequest $request): string
    {
        $user = User::create($request->getName(), $request->getEmail());
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $request->getPassword()));

        $this->userRepository->save($user);

        return $this->JWTTokenManager->create($user);
    }
}
