<?php

namespace Bookify\Domain\Users;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Shared\CustomUuid;

class User extends Entity
{
    private function __construct(
        private CustomUuid $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly Email $email,
    ) {
        parent::__construct($id);
    }

    public static function create(
        string $firstName,
        string $lastName,
        Email $email,
    ): self
    {
        $user = new static($firstName, $lastName, Email::fromString($email));

        return $user;
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