<?php

namespace Bookify\Domain\Users;

use DomainException;

class Email
{
    private function __construct(private readonly string $email)
    {
        self::assertValidEmail($email);
    }

    public static function create(string $email): self
    {
        return new self($email);
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function value(): string
    {
        return $this->email;
    }

    /**
     * @throws DomainException
     */
    private static function assertValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException("The email '{$email}' is not a valid email address.");
        }
    }

    public function equalTo(Email $email): bool
    {
        return $this->email === $email->value();
    }
}
