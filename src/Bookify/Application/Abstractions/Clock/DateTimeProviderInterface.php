<?php

namespace Bookify\Application\Abstractions\Clock;

use DateTimeImmutable;

interface DateTimeProviderInterface
{
    public static function now(?DateTimeZone $timezone = null): DateTimeImmutable;

    public function isGreaterThan(DateTimeImmutable $dateTime): bool;

    public function isEqualTo(DateTimeImmutable $dateTime): bool;

    public function isLessThan(DateTimeImmutable $dateTime): bool;
}