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
        private EncoderServiceInterface $encoderService
    ) {
    }

    public function __invoke(RegisterRequest $request): string
    {
        $user = User::create($request->getName(), $request->getEmail());
        $user->setPassword($this->encoderService->generateEncodedPasswordForUser($user, $request->getPassword()));

        $randomPassword = $this->encoderService->generateEncodedPasswordForUser($user, 'random-password');

        $this->userRepository->save($user);

        return $this->JWTTokenManager->create($user);
    }
}
