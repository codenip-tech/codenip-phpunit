<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\InvalidEmailException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class User implements UserInterface
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private ?string $password,
        private \DateTime $createdOn
    ) {
        if (!\filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::fromEmail($email);
        }
    }

    public static function create(string $name, string $email): self
    {
        return new self(Uuid::v4()->toRfc4122(), $name, $email, null, new \DateTime());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedOn(): \DateTime
    {
        return $this->createdOn;
    }

    public function getSalt(): void
    {
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
        ];
    }
}
