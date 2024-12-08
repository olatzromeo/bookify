<?php

namespace Bookify\Domain\Users;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Users\Events\UserCreated;

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
         $user = new static(CustomUuid::generate(), $firstName, $lastName, Email::fromString($email));

         $user->raiseDomainEvent(new UserCreated($user->id()));

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