<?php

namespace App\Models;


class RestaurantEvent
{
    public int $restaurantEventId;
    public int $userId;
    public int $restaurantId;
    public int $restaurantSessionId;
    public int $reservationDayId;
    public string $specificRequest;
    public string $adults;
    public string $children;
    public string $status;
    

    public function getRestaurantEventId(): int
    {
        return $this->restaurantEventId;
    }

    public function setRestaurantEventId(int $restaurantEventId): void
    {
        $this->restaurantEventId = $restaurantEventId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }


    public function getRestaurantId(): int
    {
        return $this->restaurantId;
    }

    public function setRestaurantId(int $restaurantId): void
    {
        $this->restaurantId = $restaurantId;
    }

    public function getRestaurantSessionId(): int
    {
        return $this->restaurantSessionId;
    }

    public function setRestaurantSessionId(int $restaurantSessionId): void
    {
        $this->restaurantSessionId = $restaurantSessionId;
    }


    public function getReservationDayId(): int
    {
        return $this->reservationDayId;
    }

    public function setReservationDayId(int $reservationDayId): void
    {
        $this->reservationDayId = $reservationDayId;
    }



    public function getSpecificRequest(): string
    {
        return $this->specificRequest;
    }

    public function setSpecificRequest(string $specificRequest): void
    {
        $this->specificRequest = $specificRequest;
    }

    public function getAdults(): string
    {
        return $this->adults;
    }

    public function setAdults(string $adults): void
    {
        $this->adults = $adults;
    }

    public function getChildren(): string
    {
        return $this->children;
    }

    public function setChildren(string $children): void
    {
        $this->children = $children;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    




    




    
    
}