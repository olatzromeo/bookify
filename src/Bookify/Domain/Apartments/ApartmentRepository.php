<?php

namespace Bookify\Domain\Apartments;

interface ApartmentRepository
{
    public function getById(string $id): Apartment | null;

    public function save(Apartment $apartment): void;
}