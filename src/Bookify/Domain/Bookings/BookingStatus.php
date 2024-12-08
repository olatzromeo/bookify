<?php

namespace Bookify\Domain\Bookings;

enum BookingStatus: int
{
    const RESERVED = 1;
    const CONFIRMED = 2;
    const REJECTED = 3;
    const CANCELLED = 4;
    const COMPLETED = 5;
}
