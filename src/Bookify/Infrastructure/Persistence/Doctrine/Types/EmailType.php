<?php

namespace Bookify\Infrastructure\Persistence\Doctrine\Types;

use Bookify\Domain\Shared\CustomUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const NAME = 'email';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CustomUuid
    {
        return $value !== null ? CustomUuid::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof CustomUuid) {
            return $value->value();
        }

        return (string)$value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}