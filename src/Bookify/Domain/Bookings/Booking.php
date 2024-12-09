<?php

namespace Bookify\Domain\Bookings;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Apartments\Apartment;
use Bookify\Domain\Bookings\Events\BookingCancelled;
use Bookify\Domain\Bookings\Events\BookingCompleted;
use Bookify\Domain\Bookings\Events\BookingConfirmed;
use Bookify\Domain\Bookings\Events\BookingRejected;
use Bookify\Domain\Bookings\Events\BookingReserved;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateRange;
use Bookify\Domain\Shared\DateTime;
use Bookify\Domain\Shared\Money;
use DateTimeImmutable;
use DomainException;

final class Booking extends Entity
{
    private function __construct(
        CustomUuid $id,
        private readonly CustomUuid $apartmentId,
        private readonly CustomUuid $userId,
        private readonly DateRange  $stayPeriod,
        private readonly Money $priceForPeriod,
        private readonly Money $cleaningFee,
        private readonly Money $amenitiesUpCharge,
        private readonly Money $totalPrice,
        private int $bookingStatus,
        private readonly DateTime $createdAt,
        private ?DateTime $confirmedOn = null,
        private ?DateTime $rejectedOn = null,
        private ?DateTime $completedOn = null,
        private ?DateTime $cancelledOn = null,
        array $domainEvents = []
    ) {
        parent::__construct($id, $domainEvents);
    }

    public static function reserve(
        Apartment $apartment,
        CustomUuid $userId,
        DateRange $period,
        DateTimeImmutable $createdAt,
        CalculatePrice $calculatePrice
    ): self {

        $pricingDetails = ($calculatePrice)($apartment, $period);

        $booking = new self(
            CustomUuid::generate(),
            $apartment->id(),
            $userId,
            $period,
            $pricingDetails->getPriceForPeriod(),
            $pricingDetails->getCleaningFee(),
            $pricingDetails->getAmenitiesUpCharge(),
            $pricingDetails->getTotalPrice(),
            BookingStatus::RESERVED,
            $createdAt,
        );

        $booking->raiseDomainEvent(new BookingReserved($booking->id()));

        return $booking;
    }

    public function confirm(): void
    {
        if(!$this->isReserved()) {
            throw new DomainException('The booking is not pending to confirm.');
        }

        $this->bookingStatus = BookingStatus::CONFIRMED;
        $this->confirmedOn = DateTime::now();

        $this->raiseDomainEvent(new BookingConfirmed($this->id()));
    }

    public function reject(): void
    {
        if(!$this->isReserved()) {
            throw new DomainException('The booking is not pending to confirm.');
        }

        $this->bookingStatus = BookingStatus::REJECTED;
        $this->rejectedOn = DateTime::now();

        $this->raiseDomainEvent(new BookingRejected($this->id()));
    }

    public function complete(): void
    {
        if (!$this->isConfirmed()) {
            throw new DomainException('The booking is not confirmed.');
        }

        $this->bookingStatus = BookingStatus::COMPLETED;
        $this->completedOn = DateTime::now();

        $this->raiseDomainEvent(new BookingCompleted($this->id()));
    }

    public function cancel(): void
    {
        if (!$this->isConfirmed()) {
            throw new DomainException('The booking is not confirmed.');
        }

        $currentDate = DateTime::now();
        if ($currentDate->isGreaterThan($this->stayPeriod->start())) {
            throw new DomainException('The booking has already started.');
        }

        $this->bookingStatus = BookingStatus::CANCELLED;
        $this->cancelledOn = DateTime::now();

        $this->raiseDomainEvent(new BookingCancelled($this->id()));
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

    public function getStayPeriod(): DateRange
    {
        return $this->stayPeriod;
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

    public function getBookingStatus(): int
    {
        return $this->bookingStatus;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getConfirmedOn(): ?DateTime
    {
        return $this->confirmedOn;
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

    public function isReserved(): bool
    {
        return BookingStatus::RESERVED === $this->bookingStatus;
    }

    public function isConfirmed(): bool
    {
        return BookingStatus::CONFIRMED === $this->bookingStatus;
    }

    public function isCompleted(): bool
    {
        return BookingStatus::COMPLETED === $this->bookingStatus;
    }
}
