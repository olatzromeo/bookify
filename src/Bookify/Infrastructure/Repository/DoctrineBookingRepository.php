<?php

namespace Bookify\Infrastructure\Repository;

use Bookify\Domain\Bookings\Booking;
use Bookify\Domain\Bookings\BookingRepository;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateRange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineBookingRepository extends ServiceEntityRepository implements BookingRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function getById(string $id): ?Booking
    {
        // TODO: Implement getById() method.
    }

    public function isOverlapping(DateRange $stayPeriodRange, CustomUuid $apartmentId)
    {
        // TODO: Implement isOverlapping() method.
    }

    public function save(Booking $booking): void
    {
        $this->getEntityManager()->persist($booking);
        $this->getEntityManager()->flush($booking);
    }
}