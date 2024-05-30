<?php

namespace App\Services;

use App\Repositories\PersonalProgramRepository;

class PersonalProgramService
{
    private $personalProgramRepository;

    public function __construct() {
        $this->personalProgramRepository = new PersonalProgramRepository();
    }

    public function getEventById($eventId): array
    {
        return $this->personalProgramRepository->getEventById($eventId);
    }

    public function getEventsFromUser($userId): array
    {
        return $this->personalProgramRepository->getEventsFromUser($userId);
    }

    public function getHistoryEventById($eventId): bool|array
    {
        return $this->personalProgramRepository->getHistoryEventById($eventId);
    }

    public function getRestaurantEventById($eventId): bool|array
    {
        return $this->personalProgramRepository->getRestaurantEventById($eventId);
    }

    public function getArtistEventById($eventId): bool|array
    {
        return $this->personalProgramRepository->getArtistEventById($eventId);
    }

    public function getHistoryEvent($historyEventId): array
    {
        return $this->personalProgramRepository->getHistoryEvent($historyEventId);
    }

    public function getRestaurantEvent($restaurantEventId): array
    {
        return $this->personalProgramRepository->getRestaurantEvent($restaurantEventId);
    }

    public function removeEvent($eventId, $eventType, $subEventId): void
    {
        $this->personalProgramRepository->removeEvent($eventId, $eventType, $subEventId);
    }

    public function getEventsByPaymentId($paymentId): bool|array
    {
        return $this->personalProgramRepository->getEventsByPaymentId($paymentId);
    }

    public function changeRestaurantQuantity($restaurantEventId, $adults, $children): void
    {
        $this->personalProgramRepository->changeRestaurantQuantity($restaurantEventId, $adults, $children);
    }

    public function changeHistoryQuantity($historyEventId, $participants): void
    {
        $this->personalProgramRepository->changeHistoryQuantity($historyEventId, $participants);
    }

    public function changeArtistQuantity($artistEventId, $ticketsPurchased, $userId): void
    {
        $this->personalProgramRepository->changeArtistQuantity($artistEventId, $ticketsPurchased, $userId);
    }
}