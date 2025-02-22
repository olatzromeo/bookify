<?php

namespace Bookify\Domain\Apartments;

readonly class Address
{
    private function __construct(
        private string $country,
        private string $state,
        private string $zipCode,
        private string $city,
        private string $street
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

    final public static function of(string $country, string $state, string $zipCode, string $city, string $street): self
    {
        return new static($country, $state, $zipCode, $city, $street);
    }
}