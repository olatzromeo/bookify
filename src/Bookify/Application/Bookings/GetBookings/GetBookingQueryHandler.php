<?php

namespace Bookify\Application\Bookings\GetBookings;

use Bookify\Application\Abstractions\Messaging\QueryHandler;

class GetBookingQueryHandler implements QueryHandler
{
    public function __invoke(GetBookingQuery $query): BookingResponse
    {


    }

}