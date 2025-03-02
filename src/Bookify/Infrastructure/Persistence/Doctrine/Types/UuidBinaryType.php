<?php

namespace Bookify\Infrastructure\Persistence\Doctrine\Types;

use Bookify\Domain\Shared\CustomUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BinaryType;

class UuidBinaryType extends BinaryType
{
    public const NAME = 'uuid_binary';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof CustomUuid) {
            return $value->toBinary();
        }

        return null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): CustomUuid|string|null
    {
        if (is_string($value) && strlen($value) === 16) {
            return CustomUuid::fromBinary($value);
        }

        return null;
    }

    /**
     * The UUID_TO_BIN function returns a VARBINARY(16)
     * @link https://dev.mysql.com/doc/refman/8.0/en/miscellaneous-functions.html#function_uuid-to-bin
     */
    public function getSqlDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => '16',
            'fixed' => true,
        ]);
    }

    /**
     * The MySQL functions UUID_TO_BIN and BIN_TO_UUID should be used, so we have to say Doctrine, that we want to use
     * custom SQL (Custom SQL provided by the methods convertToDatabaseValueSQL() and convertToPHPValueSQL()).
     */
    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}