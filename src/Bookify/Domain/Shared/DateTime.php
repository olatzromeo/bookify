<?php

namespace Bookify\Domain\Shared;

use DateTimeImmutable;
use DateTimeZone;

class DateTime extends DateTimeImmutable
{
    public static function now(?DateTimeZone $timezone = null): self
    {
        return new self('now', $timezone);
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