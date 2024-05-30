<?php

namespace App\Models;


class ReservationDay
{
    public int $reservationDayId;
    public string $day;

    public function getReservationDayId(): int
    {
        return $this->reservationDayId;
    }

    public function setReservationDayId(int $reservationDayId): void
    {
        $this->reservationDayId = $reservationDayId;
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function setDay(string $day): void
    {
        $this->day = $day;
    }

    


    
    




    




    
    
}