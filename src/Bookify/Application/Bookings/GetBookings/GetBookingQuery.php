<?php

namespace Bookify\Application\Bookings\GetBookings;

use Bookify\Application\Abstractions\Messaging\Query;
use Bookify\Domain\Shared\CustomUuid;

class GetBookingQuery implements Query
{
    public function __invoke(CustomUuid $bookingId): BookingResponse
    {

    }

}