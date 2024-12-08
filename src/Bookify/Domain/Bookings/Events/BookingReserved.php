<?php

namespace Bookify\Domain\Bookings\Events;

use Bookify\Domain\Abstractions\DomainEvent;
use Bookify\Domain\Shared\CustomUuid;

class BookingReserved implements DomainEvent
{
    public function __construct(
        private readonly CustomUuid $id
    ) {
    }

    public function getId(): CustomUuid
    {
        return $this->id;
    }
}