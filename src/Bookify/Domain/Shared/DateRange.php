<?php

namespace Bookify\Domain\Shared;

use DomainException;

class DateRange
{
    private function __construct(
        private readonly DateTime $start,
        private readonly DateTime $end
    ) {
        if ($this->start > $this->end) {
           throw new DomainException('Start date cannot be greater than end date');
        }
    }

    public static function create(DateTime $start, DateTime $end): self
    {
        return new self($start, $end);
    }

    public function start(): DateTime
    {
        return $this->start;
    }

    public function end(): DateTime
    {
        return $this->end;
    }

    public function lengthInDays(): int
    {
        return $this->start->diff($this->end)->days;
    }
}