<?php

namespace Bookify\Domain\Bookings;

use Bookify\Domain\Shared\Money;

class PricingDetails
{
    private function __construct(
        private readonly Money $priceForPeriod,
        private readonly Money $cleaningFee,
        private readonly Money $amenitiesUpCharge,
        private readonly Money $totalPrice
    ) {
    }

    public static function create(Money $priceForPeriod, Money $cleaningFee, Money $amenitiesUpCharge, Money $totalPrice): self
    {
        return new self($priceForPeriod, $cleaningFee, $amenitiesUpCharge, $totalPrice);
    }

    public function getPriceForPeriod(): Money
    {
        return $this->priceForPeriod;
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



}