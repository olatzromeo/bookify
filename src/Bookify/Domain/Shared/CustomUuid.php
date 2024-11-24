<?php

namespace Bookify\Domain\Shared;

use App\Shared\Domain\Exception\InvalidId;
use DomainException;

abstract class CustomUuid implements \Stringable
{
    private function __construct(
        private readonly string $value
    ) {
        if (!CustomUuid::isValid($value)) {
            throw new DomainException('UUID is not valid');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    final public static function generate(): static
    {
        $id = CustomUuid::uuid4()->toString();

        return new static($id);
    }

    final public static function fromString(string $uuid): static
    {
        return new static($uuid);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isEqualTo(self $uuid): bool
    {
        return $this->value === $uuid->value;
    }

    public function isNotEqualTo(self $uuid): bool
    {
        return $this->value !== $uuid->value;
    }
}