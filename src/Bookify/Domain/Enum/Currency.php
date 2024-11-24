<?php

namespace Bookify\Domain\Enum;

enum Currency: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case JPY = 'JPY';
    case CZK = 'CZK';
    case NONE = '';
}
