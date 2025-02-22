<?php

namespace Bookify\Domain\Bookings;

use Bookify\Domain\Apartments\Amenity;
use Bookify\Domain\Apartments\Apartment;
use Bookify\Domain\Shared\DateRange;
use Bookify\Domain\Shared\Money;

class CalculatePrice
{
    public function __invoke(Apartment $apartment, DateRange $period): PricingDetails
    {
        $currency = $apartment->price()->currency();

        $priceForPeriod = Money::fromFloat(
            $apartment->price()->amount() * $period->lengthInDays(),
            $currency
        );

        // calculate the percentage of overcharge per amenity
        $percentageUpCharge = 0;
        foreach ($apartment->amenities() as $amenity) {
            $percentageUpCharge += match ($amenity) {
                Amenity::GARDEN_VIEW => 0.05,
                Amenity::MOUNTAIN_VIEW => 0.05,
                Amenity::AIR_CONDITIONING => 0.01,
                Amenity::PARKING => 0.01,
                default => 0,
            };
        }

        // calculate the amenities surcharge
        $amenitiesUpCharge = Money::zero($currency);
        if ($percentageUpCharge > 0) {
            $amenitiesUpCharge = Money::fromFloat(
                $priceForPeriod->amount() * $percentageUpCharge,
                $currency
            );
        }

        $totalPrice = Money::zero($currency);
        $totalPrice = Money::add($totalPrice, $priceForPeriod);

        if (!$apartment->cleaningFeePrice()->isZero($currency)) {
            $totalPrice = Money::add($totalPrice, $apartment->cleaningFeePrice());
        }

        $totalPrice = Money::add($totalPrice, $amenitiesUpCharge);

        return PricingDetails::create($priceForPeriod, $apartment->cleaningFeePrice(), $amenitiesUpCharge, $totalPrice);
    }
}