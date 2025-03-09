<?php

namespace Bookify\Infrastructure\Repository;

use Bookify\Domain\Apartments\Apartment;
use Bookify\Domain\Apartments\ApartmentRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineApartmentRepository extends ServiceEntityRepository implements ApartmentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartment::class);
    }

    public function getById(string $id): ?Apartment
    {
        // TODO: Implement getById() method.
    }

    public function save(Apartment $apartment): void
    {
        $this->getEntityManager()->persist($apartment);
        $this->getEntityManager()->flush($apartment);
    }
}