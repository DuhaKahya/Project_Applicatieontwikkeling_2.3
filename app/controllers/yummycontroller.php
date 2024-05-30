<?php

namespace App\Controllers;

use App\Services\YummyService;

class YummyController extends Controller
{
    private YummyService $yummyService;

    public function __construct()
    {
        $this->yummyService = new YummyService();
    }

    public function index(): void
    {
        // Haal de gegevens op uit de service
        $restaurants = $this->yummyService->getAllRestaurants();
        $specialities = $this->yummyService->getAllSpecialities();

        // Laad de view met de opgehaalde gegevens
        require_once __DIR__ . '/../views/yummy/yummy.php';
    }
}
