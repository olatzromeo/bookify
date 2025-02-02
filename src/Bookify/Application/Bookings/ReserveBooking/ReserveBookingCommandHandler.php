<?php

namespace Bookify\Application\Bookings\ReserveBooking;

use Bookify\Application\Abstractions\Messaging\CommandHandler;
use Bookify\Domain\Apartments\ApartmentRepository;
use Bookify\Domain\Bookings\Booking;
use Bookify\Domain\Bookings\BookingRepository;
use Bookify\Domain\Bookings\CalculatePrice;
use Bookify\Domain\Shared\DateRange;
use Bookify\Domain\Users\UserRepository;
use Bookify\Infrastructure\Clock\DateTimeProvider;
use Exception;

class ReserveBookingCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private ApartmentRepository $apartmentRepository,
        private BookingRepository $bookingRepository,
        private CalculatePrice $calculatePrice,
        private readonly DateTimeProvider $dateTimeProvider
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function __invoke(ReserveBookingCommand $command): void
    {
        $user = $this->userRepository->getById($command->getUserId());
        if (null === $user) {
            throw new Exception('User not found');
        }

        $apartment = $this->apartmentRepository->getById($command->getApartmentId());
        if (null === $apartment) {
            throw new Exception('Apartment not found');
        }

        $stayPeriodRange = DateRange::create($command->getStart(), $command->getEnd());

        if ($this->bookingRepository->isOverlapping($apartment, $stayPeriodRange)) {
            throw new Exception('Apartment already booked');
        }

        $booking = Booking::reserve(
            $apartment,
            $user->id(),
            $stayPeriodRange,
            $this->dateTimeProvider::now(),
            $this->calculatePrice
        );

        $this->bookingRepository->save($booking);
    }

}