<?php

namespace Bookify\Application\Bookings\ReserveBooking;

use Bookify\Application\Abstractions\Clock\DateTimeProviderInterface;
use Bookify\Application\Abstractions\Messaging\CommandHandler;
use Bookify\Domain\Apartments\ApartmentRepository;
use Bookify\Domain\Bookings\Booking;
use Bookify\Domain\Bookings\BookingRepository;
use Bookify\Domain\Bookings\CalculatePrice;
use Bookify\Domain\Shared\DateRange;
use Bookify\Domain\Shared\DateTime;
use Bookify\Domain\Users\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReserveBookingCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private ApartmentRepository $apartmentRepository,
        private BookingRepository $bookingRepository,
        private DateTimeProviderInterface $dateTimeProvider,
        private CalculatePrice $calculatePrice
    ) {}

    public function __invoke(ReserveBookingCommand $command)
    {
        $user = $this->userRepository->getById($command->getUserId()->toString());
        if (null === $user) {
            throw new NotFoundHttpException('User not found');
        }

        $apartment = $this->apartmentRepository->getById($command->getApartmentId()->toString());
        if (null === $apartment) {
            throw new NotFoundHttpException('Apartment not found');
        }

        $duration = DateRange::create($command->getStart(), $command->getEnd());
        $isOverlapping = $this->bookingRepository->isOverlapping($duration, $apartment->id());
        if ($isOverlapping) {
            throw new \DomainException('This date range has been already booked');
        }

        $booking = Booking::reserve(
            $apartment,
            $user->id(),
            $duration,
            $this->dateTimeProvider::now(),
            $this->calculatePrice
        );

        $this->bookingRepository->save($booking);

        return $booking;
    }
}