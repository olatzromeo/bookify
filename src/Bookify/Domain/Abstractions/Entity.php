<?php

namespace Bookify\Domain\Abstractions;

use Bookify\Domain\Shared\CustomUuid;

abstract class Entity
{
    public function __construct(
        private CustomUuid $id,
        private array $domainEvents = []
    ) {
    }

    public function id(): CustomUuid
    {
        return $this->id;
    }

    public function domainEvents(): array
    {
        return $this->domainEvents;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }

    protected function raiseDomainEvent(IDomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}