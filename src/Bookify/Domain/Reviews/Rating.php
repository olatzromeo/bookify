<?php

namespace Bookify\Domain\Reviews;

use DomainException;

readonly class Rating
{
    private const MIN_RATE = 1;
    private const MAX_RATE = 5;

    private function __construct(
        private int $rateValue
    ) {
        if ( self::MIN_RATE > $this->rateValue  || self::MAX_RATE < $this->rateValue) {
            throw new DomainException('It is not a valid rate');
        }
    }

    public static function of(int $rateValue): self
    {
        return new self($rateValue);
    }
}
