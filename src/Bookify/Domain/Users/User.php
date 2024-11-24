<?php

namespace Bookify\Domain\Users;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Shared\CustomUuid;

class User extends Entity
{
    private function __construct(
        private readonly CustomUuid $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly Email $email,
    ) {
        parent::__construct($id);
    }

    public static function create(
        string $firstName,
        string $lastName,
        string $email,
    ): self {
         return new static(CustomUuid::generate(), $firstName, $lastName, Email::fromString($email));
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): Email
    {
        return $this->email;
    }
}