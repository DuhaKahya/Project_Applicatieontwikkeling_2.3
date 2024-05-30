<?php

namespace App\Controllers;

class ConfirmReservationController extends Controller
{

    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit(); 
        }
        
        // Haal de formuliergegevens op uit de queryparameters
        $restaurantName = htmlspecialchars($_GET['restaurant'] ?? '');
        $day = htmlspecialchars($_GET['day'] ?? '');
        $time = htmlspecialchars($_GET['time'] ?? '');
        $adults = htmlspecialchars($_GET['adults'] ?? '');
        $children = htmlspecialchars($_GET['children'] ?? '');
        $requests = htmlspecialchars($_GET['requests'] ?? '');

        // Toon de reserveringsdetails op de bevestigingspagina
        require_once __DIR__ . '/../views/yummy/confirmreservation.php';
    }
}