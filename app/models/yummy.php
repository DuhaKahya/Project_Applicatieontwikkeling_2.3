<?php

namespace App\Models;


class Yummy
{
    public int $restaurantId;
    public int $specialityId;
    public string $name;
    public string $description;
    public string $image;
    public string $location;
    public float $price;
    public int $places;
    public float $rating;
    public string $number;
    public string $email;

    public function getRestaurantId(): int
    {
        return $this->restaurantId;
    }

    public function setRestaurantId(int $restaurantId): void
    {
        $this->restaurantId = $restaurantId;
    }

    public function getSpecialityId(): int
    {
        return $this->specialityId;
    }

    public function setSpecialityId(int $specialityId): void
    {
        $this->specialityId = $specialityId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function setPlaces(int $places): void
    {
        $this->places = $places;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    




    
    
}