<?php

namespace Bookify\Domain\Reviews;

use Bookify\Domain\Abstractions\Entity;
use Bookify\Domain\Bookings\Booking;
use Bookify\Domain\Reviews\Events\ReviewCreated;
use Bookify\Domain\Shared\CustomUuid;
use Bookify\Domain\Shared\DateTime;
use DomainException;

class Review extends Entity
{
    private function __construct(
        CustomUuid $id,
        private readonly CustomUuid $apartmentId,
        private readonly CustomUuid $bookingId,
        private readonly CustomUuid $userId,
        private readonly Rating $rating,
        private readonly Comment $comment,
        private readonly DateTime $createdAt,
        array $domainEvents = [])
    {
        parent::__construct($id, $domainEvents);
    }

    public static function create(
        Booking $booking,
        Rating $rating,
        Comment $comment
    ): self {

        if (!$booking->isCompleted()) {
             throw new DomainException('The review is not eligible because the booking is not completed yet');
        }

        $review = new self(
            CustomUuid::generate(),
            $booking->id(),
            $booking->getApartmentId(),
            $booking->getUserId(),
            $rating,
            $comment,
            DateTime::now()
        );

        $review->raiseDomainEvent(new ReviewCreated($review->id()));

        return $review;
    }

    public function getApartmentId(): CustomUuid
    {
        return $this->apartmentId;
    }

    public function getBookingId(): CustomUuid
    {
        return $this->bookingId;
    }

    public function getUserId(): CustomUuid
    {
        return $this->userId;
    }

    public function getRating(): Rating
    {
        return $this->rating;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
