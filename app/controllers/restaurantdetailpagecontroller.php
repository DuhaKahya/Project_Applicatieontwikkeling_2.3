<?php

namespace App\Controllers;

use App\Services\RestaurantDetailPageService;
use App\Services\YummyService;

class RestaurantDetailpageController extends Controller
{
    private RestaurantDetailPageService $restaurantDetailPageService;
    private YummyService $yummyService;

    public function __construct()
    {
        $this->restaurantDetailPageService = new RestaurantDetailPageService();
        $this->yummyService = new YummyService();
    }

    public function index(): void
    {
        // Hier haal je de benodigde gegevens op vanuit de service
        $restaurantDetailPages = $this->restaurantDetailPageService->getAllRestaurantDetailPages();

        // Retrieve restaurantId based on the restaurant name
        $restaurantName = htmlspecialchars($_GET['restaurant'] ?? '');
        $restaurantId = $this->yummyService->getIdByName($restaurantName);
        $yummyDetails = $this->yummyService->getRestaurantById($restaurantId);
        $restaurantDetails = $this->restaurantDetailPageService->getRestaurantDetailsByRestaurantId($restaurantId);

        
        
        // Render de view met de opgehaalde gegevens
        require_once __DIR__ . '/../views/yummy/restaurantdetailpage.php';
    }
}

