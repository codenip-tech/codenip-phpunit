<?php

declare(strict_types=1);

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordRequest implements RequestDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=36, max=36)
     */
    private ?string $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    private ?string $currentPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    private ?string $newPassword;

    public function __construct(Request $request)
    {
        $this->id = $request->attributes->get('id');
        $this->currentPassword = $request->request->get('currentPassword');
        $this->newPassword = $request->request->get('newPassword');
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }
}
