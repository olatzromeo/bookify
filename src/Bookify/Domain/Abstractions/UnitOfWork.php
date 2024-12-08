<?php

namespace Bookify\Domain\Abstractions;

interface UnitOfWork
{
    public function save(): void;
}