<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Models\RestaurantEvent;

class ReservationService
{
    private ReservationRepository $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
    }

    // Restaurant Events

    public function insertRestaurantEvent(RestaurantEvent $restaurantEvent)
    {
        return $this->reservationRepository->insertRestaurantEvent($restaurantEvent);
    }

    // Reservations

    public function getAllReservations(): bool|array
    {
        return $this->reservationRepository->getAllReservations();
    }

    public function getReservationById(int $id): bool|RestaurantEvent
    {
        return $this->reservationRepository->getReservationById($id);
    }

    public function createReservation($userId, $restaurantId, $restaurantSessionId, $reservationDayId, $specificRequest, $adults, $children): bool
    {
        return $this->reservationRepository->createReservation($userId, $restaurantId, $restaurantSessionId, $reservationDayId, $specificRequest, $adults, $children);
    }

    public function updateReservation($restaurantEventId, $userId, $restaurantId, $restaurantSessionId, $reservationDayId, $specificRequest, $adults, $children, $status): bool
    {
        return $this->reservationRepository->updateReservation($restaurantEventId, $userId, $restaurantId, $restaurantSessionId, $reservationDayId, $specificRequest, $adults, $children, $status);
    }

    public function deleteReservation(int $id): bool
    {
        return $this->reservationRepository->deleteReservation($id);
    }

    // Sessions

    public function getAllSessions(): bool|array
    {
        return $this->reservationRepository->getAllSessions();
    }

    public function getIdByStartTimeAndEndTime(string $startTime, string $endTime): int
    {
        return $this->reservationRepository->getIdByStartTimeAndEndTime($startTime, $endTime);
    }

    // Days

    public function getAllDays(): bool|array
    {
        return $this->reservationRepository->getAllDays();
    }

    public function getIdByDay(string $day): int
    {
        return $this->reservationRepository->getIdByDay($day);
    }

    public function artistReservationConfirm($userId, $artistEventIds, $numberOfPeople)
    {
        return $this->reservationRepository->artistReservationConfirm($userId, $artistEventIds, $numberOfPeople);
    }
}
