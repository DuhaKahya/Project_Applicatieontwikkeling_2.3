<?php

namespace App\Models;
use DateTime;

class HistoryTour
{
    public int $historyTourId;
    public string $name;
    public string $tourStartTime;
    public int $maxParticipants;
    public float $price;
    public int $totalParticipants;
    public string $tourGuide;

    public function getId(): int
    {
        return $this->historyTourId;
    }

    public function getLanguage(): string
    {
        return $this->name;
    }

    public function getStartDateTime(): DateTime
    {
        return new DateTime($this->tourStartTime);
    }

    public function getStartDate(): string
    {
        return $this->getStartDateTime()->format('F-dS');
    }

    public function getMaxParticipants(): string
    {
        return $this->maxParticipants;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getTotalParticipants(): int
    {
        return $this->totalParticipants;
    }

    public function getTourGuide(): string
    {
        return $this->tourGuide;
    }
}