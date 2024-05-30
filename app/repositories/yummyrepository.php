<?php

namespace App\Repositories;

use App\Models\Yummy;
use App\Models\Speciality;
use App\Models\RestaurantSessions;

use PDO;

class YummyRepository extends Repository
{

    // Restaurants

    public function getAllRestaurants(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantId, specialityId, name, description, image, location, price, places, rating, number, email
            FROM Restaurant
        ");

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Yummy::class);
        
    }

    public function getRestaurantById($id): bool| Yummy
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantId, specialityId, name, description, image, location, price, places, rating, number, email
            FROM Restaurant
            WHERE restaurantId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(Yummy::class);
    }
    


    public function getIdByName($name): ?int
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantId
            FROM Restaurant
            WHERE name = :name
        ");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['restaurantId'] : null;
    }

    public function getPlacesById($id): ?int
    {
        $stmt = $this->connection->prepare("
            SELECT places
            FROM Restaurant
            WHERE restaurantId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['places'] : null;
    }

    public function createRestaurant($specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO Restaurant (specialityId, name, description, image, location, price, places, rating, number, email)
            VALUES (:specialityId, :name, :description, :image, :location, :price, :places, :rating, :number, :email)
        ");
        $stmt->bindParam(':specialityId', $specialityId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':places', $places);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Haal het laatst ingevoegde restaurantId op
        $restaurantId = $this->connection->lastInsertId();

        // Voeg de image details toe aan de RestaurantDetailPage tabel
        $stmt = $this->connection->prepare("
            INSERT INTO RestaurantDetailPage (restaurantId, imageDetail1, imageDetail2, imageDetail3, imageDetail4, titleDescription, description, reservationText)
            VALUES (:restaurantId, :imageDetail1, :imageDetail2, :imageDetail3, :imageDetail4, :titleDescription, :pageDescription, :reservationText)
        ");
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':imageDetail1', $imageDetail1);
        $stmt->bindParam(':imageDetail2', $imageDetail2);
        $stmt->bindParam(':imageDetail3', $imageDetail3);
        $stmt->bindParam(':imageDetail4', $imageDetail4);
        $stmt->bindParam(':titleDescription', $titleDescription);
        $stmt->bindParam(':pageDescription', $pageDescription);
        $stmt->bindParam(':reservationText', $reservationText);
        return $stmt->execute();
    }


    public function updateRestaurant($id, $specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE Restaurant r
            JOIN RestaurantDetailPage rp ON r.restaurantId = rp.restaurantId
            SET r.specialityId = :specialityId, r.name = :name, r.description = :description, r.image = :image, r.location = :location, r.price = :price, r.places = :places, r.rating = :rating, r.number = :number, r.email = :email, rp.imageDetail1 = :imageDetail1, rp.imageDetail2 = :imageDetail2, rp.imageDetail3 = :imageDetail3, rp.imageDetail4 = :imageDetail4, rp.titleDescription = :titleDescription, rp.description = :pageDescription, rp.reservationText = :reservationText
            WHERE r.restaurantId = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':specialityId', $specialityId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':places', $places);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':imageDetail1', $imageDetail1);
        $stmt->bindParam(':imageDetail2', $imageDetail2);
        $stmt->bindParam(':imageDetail3', $imageDetail3);
        $stmt->bindParam(':imageDetail4', $imageDetail4);
        $stmt->bindParam(':titleDescription', $titleDescription);
        $stmt->bindParam(':pageDescription', $pageDescription);
        $stmt->bindParam(':reservationText', $reservationText);

        return $stmt->execute();
    }



    public function deleteRestaurant($id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM Restaurant
            WHERE restaurantId = :id
        ");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Sessions

    public function getAllSessions(): bool | array
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantSessionId, startTime, endTime
            FROM RestaurantSessions
        ");

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, RestaurantSessions::class);
    }

    public function getSessionById($id): bool | RestaurantSessions
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantSessionId, startTime, endTime
            FROM RestaurantSessions
            WHERE restaurantSessionId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(RestaurantSessions::class);
    }

    public function createSession($startTime, $endTime): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO RestaurantSessions (startTime, endTime)
            VALUES ( :startTime, :endTime)
        ");
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        return $stmt->execute();
    }

    public function updateSession($restaurantSessionId, $startTime, $endTime): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE RestaurantSessions
            SET restaurantSessionId = :restaurantSessionId, startTime = :startTime, endTime = :endTime
            WHERE restaurantSessionId = :restaurantSessionId
        ");
        $stmt->bindParam(':restaurantSessionId', $restaurantSessionId);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        return $stmt->execute();
    }

    public function deleteSession($restaurantSessionId): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM RestaurantSessions
            WHERE restaurantSessionId = :restaurantSessionId
        ");
        $stmt->bindParam(':restaurantSessionId', $restaurantSessionId);
        return $stmt->execute();
    }

    
    

    // Specialities

    public function getAllSpecialities(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT specialityId, name, flag
            FROM Speciality
        ");

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Speciality::class);
        
    }

    public function getSpecialityById($id): bool| Speciality
    {
        $stmt = $this->connection->prepare("
            SELECT specialityId, name, flag
            FROM Speciality
            WHERE specialityId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(Speciality::class);
    }

    // Places
    public function getAvailablePlaces(int $restaurantId, int $restaurantSessionId, int $reservationDayId): int
    {
        $stmt = $this->connection->prepare("
            SELECT (r.places - COALESCE((
                SELECT SUM(adults + children)
                FROM RestaurantEvent
                WHERE restaurantId = :restaurantId
                AND restaurantSessionId = :restaurantSessionId
                AND reservationDayId = :reservationDayId
            ), 0)) AS availablePlaces
            FROM Restaurant r
            WHERE r.restaurantId = :restaurantId
        ");
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':restaurantSessionId', $restaurantSessionId);
        $stmt->bindParam(':reservationDayId', $reservationDayId);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result !== false ? (int) $result : 0;
    }


    
    
}
