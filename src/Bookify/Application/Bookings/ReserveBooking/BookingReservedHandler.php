<?php

namespace Bookify\Application\Bookings\ReserveBooking;

use Bookify\Application\Abstractions\Email\EmailService;
use Bookify\Application\Abstractions\Messaging\DomainEventHandler;
use Bookify\Domain\Bookings\BookingRepository;
use Bookify\Domain\Bookings\Events\BookingReserved;
use Bookify\Domain\Users\UserRepository;
use Exception;

class BookingReservedHandler implements DomainEventHandler
{
    public function __construct(
        private readonly BookingRepository $bookingRepository,
        private readonly UserRepository $userRepository,
        private readonly EMAILService $emailService
    ) {}

    public function __invoke(BookingReserved $bookingReserved)
    {
        $booking = $this->bookingRepository->getById($bookingReserved->getId());
        if (null === $booking) {
            throw new Exception('Booking was not found');
        }

        $user = $this->userRepository->getById($booking->getUserId());
        if (null === $user) {
            throw new Exception('User was not found');
        }

        $this->emailService->sendAsync(
            $user->email()->value(),
            'Booking reserved!',
            'You have 10 minutes to confirm this booking'
        );
    }
}