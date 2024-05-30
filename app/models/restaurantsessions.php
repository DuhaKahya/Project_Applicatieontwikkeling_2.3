<?php

namespace App\Models;


class RestaurantSessions
{
    public int $restaurantSessionId;
    public string $startTime;
    public string $endTime;

    public function getRestaurantSessionId(): int
    {
        return $this->restaurantSessionId;
    }

    public function setRestaurantSessionId(int $restaurantSessionId): void
    {
        $this->restaurantSessionId = $restaurantSessionId;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function setEndTime(string $endTime): void
    {
        $this->endTime = $endTime;
    }

    
    




    




    
    
}