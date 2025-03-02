<?php

namespace Bookify\Domain\Shared;

use DomainException;
use Symfony\Component\Uid\Uuid;

abstract class CustomUuid
{
    private Uuid $uuid;

    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        $uuid = Uuid::v4();

        return new static($uuid);
    }

    public function toString(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function toBinary(): string
    {
        return $this->uuid->toBinary();
    }

    public static function fromString(string $stringUuid): self
    {
        if (!Uuid::isValid($stringUuid)) {
            throw new DomainException('UUID is not valid');
        }

        return new static(Uuid::fromString($stringUuid));
    }

    public static function fromBinary(string $binary): self
    {
        return new static(Uuid::fromBinary($binary));
    }

    public function isEqualTo(self $otherUuid): bool
    {
        return $this->toString() === $otherUuid->toString();
    }

    public function isNotEqualTo(self $otherUuid): bool
    {
        return $this->toString() !== $otherUuid->toString();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}