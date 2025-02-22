<?php

namespace Bookify\Infrastructure\Persistence\Doctrine\Types;

use Bookify\Domain\Shared\DateTime;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DateTimeType extends DateType
{
    public const NAME = 'datetime';

    public function convertToPHPValue($value, AbstractPlatform $platform): DateTime
    {
        if ($value instanceof DateTime) {
            return DateTime::fromString($value);
        }

        return parent::convertToPHPValue($value, $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof DateTime) {
            return $value->format('Y-m-d H:i:s');
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}