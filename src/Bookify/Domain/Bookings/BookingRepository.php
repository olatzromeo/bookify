<?php

namespace Bookify\Domain\Bookings;

use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateRange;

interface BookingRepository
{
    public function isOverlapping(DateRange $stayPeriodRange, CustomUuid $apartmentId);

    public function add(Booking $booking): void;

}