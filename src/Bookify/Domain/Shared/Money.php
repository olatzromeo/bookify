<?php

namespace Bookify\Domain\Shared;

class Money
{
    private function __construct(
        private readonly float $amount,
        private readonly Currency $currency,
    ) {
    }

    public static function fromFloat(float $amount, Currency $currency): self
    {
        return new self($amount, $currency);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public static function add(self $firstAmountOfMoney, self $secondAmountOfMoney): self
    {
        if ($firstAmountOfMoney->currency()->isEqual($secondAmountOfMoney->currency())) {
            throw new \DomainException('Currency must be equal');
        }

        return new static($firstAmountOfMoney->amount + $secondAmountOfMoney->amount, $firstAmountOfMoney->currency());
    }

    public static function zero(Currency $currency): self
    {
        return new static(0, $currency);
    }

    public function isZero(Currency $currency): bool
    {
        return $this === $this->zero($currency);
    }
}
