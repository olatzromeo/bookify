<?php

namespace Bookify\Domain\Shared;

use App\Shared\Domain\Exception\InvalidDateTime;
use DateTimeImmutable;
use DateTimeZone;

class DateTime extends DateTimeImmutable
{
    public static function now(?DateTimeZone $timezone = null): self
    {
        return new self('now', $timezone);
    }

    public static function fromString(string $dateTime): self
    {
        return self::create($dateTime);
    }

    private static function create(string $dateTime = ''): self
    {
        try {
            return new self($dateTime);
        } catch (\Throwable $e) {
            throw new InvalidDateTime($dateTime);
        }
    }

    public function isGreaterThan(self $dateTime): bool
    {
        return $this->getTimestamp() > $dateTime->getTimestamp();
    }

    public function isEqualTo(self $dateTime): bool
    {
        return $this->getTimestamp() === $dateTime->getTimestamp();
    }

    public function isLessThan(self $dateTime): bool
    {
        return $this->getTimestamp() < $dateTime->getTimestamp();
    }
}