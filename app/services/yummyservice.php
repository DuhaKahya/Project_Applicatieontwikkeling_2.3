<?php

namespace App\Services;

use App\Repositories\YummyRepository;
use App\Models\Yummy;
use App\Models\Speciality;
use App\Models\RestaurantSessions;

class YummyService
{
    private YummyRepository $yummyRepository;

    public function __construct()
    {
        $this->yummyRepository = new YummyRepository();    
    }

    // Restaurants

    public function getAllRestaurants(): bool|array
    {
        return $this->yummyRepository->getAllRestaurants();
    }

    public function getRestaurantById($id): bool|Yummy
    {
        return $this->yummyRepository->getRestaurantById($id);
    }

    public function getIdByName($name): bool|int
    {
        return $this->yummyRepository->getIdByName($name);
    }

    public function getPlacesById($id): bool|int
    {
        return $this->yummyRepository->getPlacesById($id);
    }

    public function createRestaurant($specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText): bool
    {
        return $this->yummyRepository->createRestaurant($specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText);
    } 

    public function updateRestaurant($id, $specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText): bool
    {
        return $this->yummyRepository->updateRestaurant($id, $specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText);
    }

    public function deleteRestaurant($id): bool
    {
        return $this->yummyRepository->deleteRestaurant($id);
    }

    // Sessions
    
    public function getAllSessions(): bool|array
    {
        return $this->yummyRepository->getAllSessions();
    }

    public function getSessionById($id): bool|RestaurantSessions
    {
        return $this->yummyRepository->getSessionById($id);
    }

    public function createSession($startTime, $endTime): bool
    {
        return $this->yummyRepository->createSession($startTime, $endTime);
    }

    public function updateSession($restaurantId, $startTime, $endTime): bool
    {
        return $this->yummyRepository->updateSession($restaurantId, $startTime, $endTime);
    }

    public function deleteSession($id): bool
    {
        return $this->yummyRepository->deleteSession($id);
    }


    // Specialities

    public function getAllSpecialities(): bool|array
    {
        return $this->yummyRepository->getAllSpecialities();
    }

    public function getSpecialityById($id): bool|Speciality
    {
        return $this->yummyRepository->getSpecialityById($id);
    }

    // Places

    public function getAvailablePlaces($restaurantId, $restaurantSessionId, $reservationDayId): bool|int
    {
        return $this->yummyRepository->getAvailablePlaces($restaurantId, $restaurantSessionId, $reservationDayId);
    }
    






}
