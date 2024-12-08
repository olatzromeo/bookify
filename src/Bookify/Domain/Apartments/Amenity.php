<?php

namespace Bookify\Domain\Apartments;

enum Amenity: int
{
    case WIFI = 1;
    case AIR_CONDITIONING = 2;
    case PARKING = 3;
    case PET_FRIENDLY = 4;
    case SWIMMING_POOL = 5;
    case GYM = 6;
    case SPA = 7;
    case TERRACE = 8;
    case MOUNTAIN_VIEW = 9;
    case GARDEN_VIEW = 10;
}
