<?php

namespace App\Controllers;

use App\Services\EntityService;

class ReservationController extends Controller
{
    private EntityService $entityService;
    public function __construct()
    {
        $this->entityService = new EntityService();
    }
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        $entityType = $_GET['type'] ?? 'artistEvent';
        $entities = $this->entityService->getAllEntitiesWithNames($entityType);

        $selectedQuantities = $_SESSION['selectedQuantities'] ?? [];

        require_once __DIR__ . '/../views/jazz/reservation.php';

    }

    public function redirect(): void
    {
        $entityType = $_GET['type'] ?? 'artistEvent';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['selectedEntitiesDetails'] = [];

            foreach ($_POST['entities'] as $id => $quantity) {
                if ($quantity > 0) {
                    $entityDetails = $this->entityService->getEntityDetailsById($entityType, $id);
                    if ($entityDetails) {
                        $_SESSION['selectedEntitiesDetails'][] = array_merge($entityDetails, ['quantity' => $quantity]);
                    }
                }
            }

            header('Location: /reservationconfirm');
            exit;
        }
    }
}
