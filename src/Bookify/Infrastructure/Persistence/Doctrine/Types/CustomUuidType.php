<?php

namespace Bookify\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Types\StringType;

class CustomUuidType extends StringType
{
    const NAME = 'custom_uuid';


}