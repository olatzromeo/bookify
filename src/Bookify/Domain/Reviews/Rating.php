<?php

namespace Bookify\Domain\Reviews;

use DomainException;

readonly class Rating
{
    private const MIN_RATE = 1;
    private const MAX_RATE = 5;

    private function __construct(
        private int $rate
    ) {
        if ( self::MIN_RATE > $this->rate  || self::MAX_RATE < $this->rate) {
            throw new DomainException('It is not a valid rate');
        }
    }

    public static function of(int $rateValue): self
    {
        return new self($rateValue);
    }
}
