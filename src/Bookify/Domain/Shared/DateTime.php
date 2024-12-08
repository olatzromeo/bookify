<?php

namespace Bookify\Domain\Shared;

use DateTimeImmutable;

class DateTime extends DateTimeImmutable
{
    public static function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}