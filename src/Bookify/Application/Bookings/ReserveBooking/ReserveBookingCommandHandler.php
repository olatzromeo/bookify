<?php

namespace Bookify\Application\Bookings\ReserveBooking;

use Bookify\Application\Abstractions\CommandHandler;
use Bookify\Domain\Abstractions\UnitOfWork;
use Bookify\Domain\Apartments\ApartmentRepository;
use Bookify\Domain\Bookings\Booking;
use Bookify\Domain\Bookings\BookingRepository;
use Bookify\Domain\Bookings\CalculatePrice;
use Bookify\Domain\Shared\DateRange;
use Bookify\Domain\Users\UserRepository;
use Exception;

class ReserveBookingCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ApartmentRepository $apartmentRepository,
        private readonly BookingRepository $bookingRepository,
        private readonly UnitOfWork $unitOfWork,
        private readonly CalculatePrice $calculatePrice
    ) {
    }

    public function __invoke(ReserveBookingCommand $command)
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
            $this->calculatePrice
        );
    }

}