<?php

namespace Bookify\Domain\Apartments;

class Address
{
    private function __construct(
        private readonly string $country,
        private readonly string $state,
        private readonly string $zipCode,
        private readonly string $city,
        private readonly string $street
    ) {
    }

    public function country(): string
    {
        return $this->country;
    }

    public function state(): string
    {
        return $this->state;
    }

    public function zipCode(): string
    {
        return $this->zipCode;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function street(): string
    {
        return $this->street;
    }

    final public static function create(string $country, string $state, string $zipCode, string $city, string $street): self
    {
        return new static($country, $state, $zipCode, $city, $street);
    }
}