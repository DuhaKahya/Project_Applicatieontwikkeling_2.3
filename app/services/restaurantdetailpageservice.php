<?php

namespace App\Services;

use App\Repositories\RestaurantDetailPageRepository;
use App\Repositories\YummyRepository;

use App\Models\Yummy;
use App\Models\RestaurantDetailPage;

class RestaurantDetailPageService
{
    private RestaurantDetailPageRepository $restaurantDetailPageRepository;
    private YummyRepository $yummyRepository;

    public function __construct()
    {
        $this->restaurantDetailPageRepository = new RestaurantDetailPageRepository();
        $this->yummyRepository = new YummyRepository();

    }

    public function getAllRestaurantDetailPages(): bool | array
    {
        return $this->restaurantDetailPageRepository->getAllRestaurantDetailPages();
    }

    public function getIdByName($name): bool | Yummy
    {
        return $this->yummyRepository->getIdByName($name);
    }

    public function getRestaurantDetailsByRestaurantId($id): bool | RestaurantDetailPage
    {
        return $this->restaurantDetailPageRepository->getRestaurantDetailsByRestaurantId($id);
    }

    public function deleteRestaurantDetailPage($id): bool
    {
        return $this->restaurantDetailPageRepository->deleteRestaurantDetailPage($id);
    }





    

  
    





}
