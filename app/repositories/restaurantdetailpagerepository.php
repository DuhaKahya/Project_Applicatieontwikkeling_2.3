<?php

namespace App\Repositories;

use App\Models\RestaurantDetailPage;
use App\Models\Yummy;

class RestaurantDetailPageRepository extends Repository
{

    public function getAllRestaurantDetailPages(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantDetailPageId, restaurantId, titleDescription, description, reservationText, imageDetail1, imageDetail2, imageDetail3, imageDetail4
            FROM RestaurantDetailPage
        ");

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, RestaurantDetailPage::class);
        
    }

    public function getRestaurantDetailsByRestaurantId($id): bool|RestaurantDetailPage
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantDetailPageId, restaurantId, titleDescription, description, reservationText, imageDetail1, imageDetail2, imageDetail3, imageDetail4
            FROM RestaurantDetailPage
            WHERE restaurantId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(RestaurantDetailPage::class);
    }

    public function deleteRestaurantDetailPage($id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM RestaurantDetailPage
            WHERE restaurantDetailPageId = :id
        ");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    
    
    



    
    

}