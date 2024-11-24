<?php

namespace Bookify\Domain\Shared;

use Bookify\Domain\Enum\Currency AS CurrencyEnum;
use DomainException;

class Currency
{
    private function __construct(
        private string $code
    ) {
        if (!$this->isValidCurrencyCode($this->code)) {
            throw new DomainException('Is not a valid currency');
        }
    }

    public function code(): string
    {
        return $this->code;
    }

    public static function fromCode(string $code): self
    {
        return new static($code);
    }

    public function isEqual(self $currency): bool
    {
        return $this->code === $currency->code();
    }

    public function all(): array
    {
        return CurrencyEnum::cases();
    }

    private function isValidCurrencyCode(string $code): bool
    {
        return in_array($code, CurrencyEnum::cases());
    }
}