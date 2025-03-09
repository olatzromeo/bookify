<?php

namespace Bookify\Domain\Bookings;

use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateRange;

interface BookingRepository
{
    public function getById(string $id): Booking | null;

    public function isOverlapping(DateRange $stayPeriodRange, CustomUuid $apartmentId);

    public function save(Booking $booking): void;

}