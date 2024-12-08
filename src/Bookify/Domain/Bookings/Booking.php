<?php

namespace Bookify\Domain\Bookings;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateRange;
use Bookify\Domain\Shared\DateTime;
use Bookify\Domain\Shared\Money;

final class Booking extends Entity
{
    private function __construct(
        private readonly CustomUuid $id,
        private readonly CustomUuid $apartmentId,
        private readonly CustomUuid $userId,
        private readonly DateRange $duration,
        private readonly Money $priceForPeriod,
        private readonly Money $cleaningFee,
        private readonly Money $amenitiesUpCharge,
        private readonly Money $totalPrice,
        private readonly BookingStatus  $bookingStatus,
        private readonly DateTime $createdAt,
        private readonly DateTime $rejectedOn,
        private readonly DateTime $completedOn,
        private readonly DateTime $cancelledOn,
        array $domainEvents = [])
    {
        parent::__construct($id, $domainEvents);
    }

    public static function reserve (
        CustomUuid $apartmentId,
        CustomUuid $userId,
        DateRange $duration
    ): self {
        return new self(CustomUuid::generate(), $apartmentId, $userId, $duration);
    }

    public function getApartmentId(): CustomUuid
    {
        return $this->apartmentId;
    }

    public function getUserId(): CustomUuid
    {
        return $this->userId;
    }

    public function getPriceForPeriod(): Money
    {
        return $this->priceForPeriod;
    }

    public function getDuration(): DateRange
    {
        return $this->duration;
    }

    public function getCleaningFee(): Money
    {
        return $this->cleaningFee;
    }

    public function getAmenitiesUpCharge(): Money
    {
        return $this->amenitiesUpCharge;
    }

    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    public function getBookingStatus(): BookingStatus
    {
        return $this->bookingStatus;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getRejectedOn(): DateTime
    {
        return $this->rejectedOn;
    }

    public function getCompletedOn(): DateTime
    {
        return $this->completedOn;
    }

    public function getCancelledOn(): DateTime
    {
        return $this->cancelledOn;
    }
}