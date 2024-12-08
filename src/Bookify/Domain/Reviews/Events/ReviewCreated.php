<?php

namespace Bookify\Domain\Reviews\Events;

use Bookify\Domain\Abstractions\DomainEvent;
use Bookify\Domain\Shared\CustomUuid;

class ReviewCreated implements DomainEvent
{
    public function __construct(
        private readonly CustomUuid $id
    ) {
    }

    public function getId(): CustomUuid
    {
        return $this->id;
    }
}