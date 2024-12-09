<?php

namespace Bookify\Application\Bookings\ReserveBooking;

use Bookify\Application\Abstractions\Command;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateTime;

class ReserveBookingCommand implements Command
{
    public function __construct(
        private CustomUuid $apartmentId,
        private CustomUuid $userId,
        private DateTime $start,
        private DateTime $end
    ) {
    }

    public function getApartmentId(): CustomUuid
    {
        return $this->apartmentId;
    }

    public function getUserId(): CustomUuid
    {
        return $this->userId;
    }

    public function getStart(): DateTime
    {
        return $this->start;
    }

    public function getEnd(): DateTime
    {
        return $this->end;
    }
}