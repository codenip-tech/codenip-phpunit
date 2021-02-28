<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exception\InvalidEmailException;
use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class JsonExceptionTransformerListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $data = [
            'class' => \get_class($exception),
            'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $exception->getMessage(),
        ];

        if (\in_array($data['class'], $this->getNotFoundExceptions(), true)) {
            $data['code'] = JsonResponse::HTTP_NOT_FOUND;
        }

        if (\in_array($data['class'], $this->getConflictExceptions(), true)) {
            $data['code'] = JsonResponse::HTTP_CONFLICT;
        }

        if (\in_array($data['class'], $this->getBadRequestExceptions(), true)) {
            $data['code'] = JsonResponse::HTTP_BAD_REQUEST;
        }

        if ($exception instanceof HttpExceptionInterface) {
            $data['code'] = $exception->getStatusCode();
        }

        if ($exception instanceof AuthenticationException) {
            $data['code'] = JsonResponse::HTTP_UNAUTHORIZED;
        }

        $event->setResponse($this->prepareResponse($data));
    }

    private function prepareResponse(array $data): JsonResponse
    {
        $response = new JsonResponse($data, $data['code']);
        $response->headers->set('X-Error-Code', $data['code']);
        $response->headers->set('X-Server-Time', \time());

        return $response;
    }

    private function getNotFoundExceptions(): array
    {
        return [UserNotFoundException::class];
    }

    private function getConflictExceptions(): array
    {
        return [UserAlreadyExistsException::class];
    }

    public function getBadRequestExceptions(): array
    {
        return [InvalidEmailException::class];
    }
}
