<?php

namespace App\Models;

class Event
{
    public int $eventId;
    public int $historyEventId;
    public int $restaurantEventId;
    public int $artistEventId;
    public int $userId;

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function getHistoryEventId(): int
    {
        return $this->historyEventId;
    }

    public function setHistoryEventId(int $historyEventId): void
    {
        $this->historyEventId = $historyEventId;
    }

    public function getRestaurantEventId(): int
    {
        return $this->restaurantEventId;
    }

    public function setRestaurantEventId(int $restaurantEventId): void
    {
        $this->restaurantEventId = $restaurantEventId;
    }

    public function getArtistEventId(): int
    {
        return $this->artistEventId;
    }

    public function setArtistEventId(int $artistEventId): void
    {
        $this->artistEventId = $artistEventId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    
}
