<?php

namespace Bookify\Domain\Apartments;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateTime;
use Bookify\Domain\Shared\Money;

class Apartment extends Entity
{
    private function __construct(
        protected readonly CustomUuid $apartmentId,
        private readonly string $name,
        private readonly string $description,
        private readonly Address $address,
        private readonly Money $price,
        private readonly Money $cleaningFeePrice,
        private readonly DateTime $lastBookedAt,
        private readonly array $amenities
    ) {
        parent::__construct($apartmentId);
    }

    public static function create(
        string $name,
        string $description,
        Address $address,
        Money $price,
        Money $cleaningFeePrice,
        DateTime $lastBookedAt,
        array $amenities
    ): self {
        return new self(CustomUuid::generate(), $name, $description, $address, $price, $cleaningFeePrice, $lastBookedAt, $amenities);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function address(): Address
    {
        return $this->address;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function cleaningFeePrice(): Money
    {
        return $this->cleaningFeePrice;
    }

    public function lastBookedAt(): DateTime
    {
        return $this->lastBookedAt;
    }

    public function amenities(): array
    {
        return $this->amenities;
    }
}
