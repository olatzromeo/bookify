<?php

namespace Bookify\Application\Bookings\ReserveBooking;

use Bookify\Application\Abstractions\Email\EmailService;
use Bookify\Application\Abstractions\Messaging\DomainEventHandler;
use Bookify\Domain\Bookings\BookingRepository;
use Bookify\Domain\Bookings\Events\BookingReserved;
use Bookify\Domain\Users\UserRepository;

final class BookingReservedDomainEventHandler implements DomainEventHandler
{
    public function __construct(
        private readonly BookingRepository $bookingRepository,
        private readonly UserRepository $userRepository,
        private readonly EmailService $emailService
    ) {}

    public function __invoke(BookingReserved $event)
    {
        $booking = $this->bookingRepository->getById($event->getId()->toString());
        if (null === $booking) {
           return;
        }

        $user = $this->userRepository->getById($booking->getUserId()->toString());
        if (null === $user) {
            return;
        }

        $this->emailService->sendAsync(
            $user->email(),
            'Booking reserved!',
            'You have 10 minutes to confirm this booking'
        );

    }
}