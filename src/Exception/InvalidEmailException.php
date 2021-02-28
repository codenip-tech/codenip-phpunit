<?php

declare(strict_types=1);

namespace App\Exception;

class InvalidEmailException extends \DomainException
{
    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf('Invalid email %s', $email));
    }
}
