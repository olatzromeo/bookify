<?php

namespace Bookify\Infrastructure\Persistence\Doctrine\Types;

use Bookify\Domain\Users\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use DomainException;

class EmailType extends StringType
{
    public const NAME = 'email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if(!$value instanceof Email) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                ['null', Email::class],
            );
        }

        return parent::convertToDatabaseValue($value->value(), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        $value = parent::convertToPHPValue($value, $platform);

        if ($value === null) {
            return null;
        }

        try {
            return Email::create($value);
        } catch (DomainException $e) {
            throw ConversionException::conversionFailed(
                $value,
                $this->getName(),
                $e,
            );
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
