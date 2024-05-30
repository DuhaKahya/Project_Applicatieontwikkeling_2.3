<?php

namespace App\Models;


class RestaurantDetailPage
{
    public int $restaurantDetailPageId;
    public int $restaurantId;
    public string $titleDescription;
    public string $description;
    public string $reservationText;
    public string $imageDetail1;
    public string $imageDetail2;
    public string $imageDetail3;
    public string $imageDetail4;

    public function getRestaurantDetailPageId(): int
    {
        return $this->restaurantDetailPageId;
    }

    public function setRestaurantDetailPageId(int $restaurantDetailPageId): void
    {
        $this->restaurantDetailPageId = $restaurantDetailPageId;
    }

    public function getRestaurantId(): int
    {
        return $this->restaurantId;
    }

    public function setRestaurantId(int $restaurantId): void
    {
        $this->restaurantId = $restaurantId;
    }

    public function getTitleDescription(): string
    {
        return $this->titleDescription;
    }

    public function setTitleDescription(string $titleDescription): void
    {
        $this->titleDescription = $titleDescription;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getReservationText(): string
    {
        return $this->reservationText;
    }

    public function setReservationText(string $reservationText): void
    {
        $this->reservationText = $reservationText;
    }

    public function getImageDetail1(): string
    {
        return $this->imageDetail1;
    }

    public function setImageDetail1(string $imageDetail1): void
    {
        $this->imageDetail1 = $imageDetail1;
    }

    public function getImageDetail2(): string
    {
        return $this->imageDetail2;
    }

    public function setImageDetail2(string $imageDetail2): void
    {
        $this->imageDetail2 = $imageDetail2;
    }

    public function getImageDetail3(): string
    {
        return $this->imageDetail3;
    }

    public function setImageDetail3(string $imageDetail3): void
    {
        $this->imageDetail3 = $imageDetail3;
    }

    public function getImageDetail4(): string
    {
        return $this->imageDetail4;
    }

    public function setImageDetail4(string $imageDetail4): void
    {
        $this->imageDetail4 = $imageDetail4;
    }

    

}
    
