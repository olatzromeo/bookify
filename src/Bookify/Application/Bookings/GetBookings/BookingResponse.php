<?php

namespace Bookify\Application\Bookings\GetBookings;

use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateTime;

class BookingResponse
{
    public CustomUuid $id;
    public CustomUuid $userId;
    public CustomUuid $apartmentId;
    public int $status;
    public float $priceAmount;
    public string $priceCurrency;
    public string $cleaningFeeAmount;
    public string $cleaningFeeCurrency;
    public string $amenitiesUpChargeAmount;
    public string $amenititesUpChargeCurrency;
    public float $totalPriceAmount;
    public string $totalPriceCurrency;
    public DateTime $durationStart;
    public DateTime $durationEnd;
    public DateTime $createdAt;
}