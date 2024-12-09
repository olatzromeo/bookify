<?php

namespace Bookify\Infrastructure\Clock;

use Bookify\Application\Abstractions\Clock\DateTimeProviderInterface;
use DateTimeImmutable;

class DateTimeProvider implements DateTimeProviderInterface
{
    public function now(): DateTimeImmutable
    {
        // TODO: Implement now() method.
    }

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