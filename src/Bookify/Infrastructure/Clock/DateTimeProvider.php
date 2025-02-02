<?php

namespace Bookify\Infrastructure\Clock;

use Bookify\Application\Abstractions\Clock\DateTimeProviderInterface;
use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;

class DateTimeProvider extends DateTimeImmutable implements DateTimeProviderInterface
{
    /**
     * @throws DateMalformedStringException
     */
    public static function now(?DateTimeZone $timezone = null): DateTimeImmutable
    {
        return new self('now', $timezone);
    }

    public function isGreaterThan(DateTimeImmutable $dateTime): bool
    {
        return $this->getTimestamp() > $dateTime->getTimestamp();
    }

    public function isEqualTo(DateTimeImmutable $dateTime): bool
    {
        return $this->getTimestamp() === $dateTime->getTimestamp();
    }

    public function isLessThan(DateTimeImmutable $dateTime): bool
    {
        return $this->getTimestamp() < $dateTime->getTimestamp();
    }
}