<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\User;
use App\Http\DTO\RegisterRequest;
use App\Repository\UserRepository;
use App\Service\EncoderServiceInterface;
use App\Service\RegisterActionService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RegisterActionServiceTest extends TestCase
{
    private MockObject|UserRepository $userRepository;
    private MockObject|JWTTokenManagerInterface $JWTTokenManager;
    private MockObject|EncoderServiceInterface $encoderService;
    private MockObject|RegisterRequest $request;
    private RegisterActionService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $this->JWTTokenManager = $this->getMockBuilder(JWTTokenManagerInterface::class)->disableOriginalConstructor()->getMock();
        $this->encoderService = $this->getMockBuilder(EncoderServiceInterface::class)->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder(RegisterRequest::class)->disableOriginalConstructor()->getMock();

        $this->service = new RegisterActionService($this->userRepository, $this->JWTTokenManager, $this->encoderService);
    }

    public function testRegisterActionService(): void
    {
        $this->request->method('getName')->willReturn('Juan');
        $this->request->method('getEmail')->willReturn('juan@api.com');
        $this->request->method('getPassword')->willReturn('pass123');

        $this->encoderService
            ->expects($this->exactly(2))
            ->method('generateEncodedPasswordForUser')
            ->with($this->isInstanceOf(User::class), $this->isType('string'))
            ->willReturn('encoded-password', 'new-random-password');

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->JWTTokenManager
            ->expects($this->exactly(1))
            ->method('create')
            ->with($this->isInstanceOf(User::class))
            ->willReturn('my-json-web-token');

        $response = $this->service->__invoke($this->request);

        self::assertIsString($response);
    }
}
