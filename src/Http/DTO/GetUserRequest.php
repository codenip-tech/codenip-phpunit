<?php

declare(strict_types=1);

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetUserRequest implements RequestDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private ?string $email;

    public function __construct(Request $request)
    {
        $this->email = $request->query->get('email');
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
