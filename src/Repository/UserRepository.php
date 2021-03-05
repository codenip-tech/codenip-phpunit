<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, User::class);
    }

    public function byIdOrFail(string $id): User
    {
        if (null === $user = $this->find($id)) {
            throw UserNotFoundException::fromId($id);
        }

        return $user;
    }

    public function byEmailOrFail(string $email): User
    {
        if (null === $user = $this->findOneBy(['email' => $email])) {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }

    public function save(User $user): void
    {
        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException) {
            throw UserAlreadyExistsException::fromEmail($user->getEmail());
        }
    }
}
