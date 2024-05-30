<?php

namespace App\Controllers;

use App\Helpers\FlashHelper;
use App\Services\EntityService;
use App\Services\ReservationService;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class ReservationConfirmController extends Controller
{
    private ReservationService $reservationService;
    private FlashHelper $flashHelper;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->flashHelper = new FlashHelper();
    }

    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }
        $selectedEntities = $_SESSION['selectedEntitiesDetails'] ?? [];

        require_once __DIR__ . '/../views/jazz/reservationconfirm.php';
    }

    #[NoReturn] public function confirm(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        $entityIds = $_POST['entityIds'] ?? [];
        $quantities = $_POST['entities'] ?? [];

        $errors = $this->validateInput($userId, $entityIds, $quantities);

        if (!empty($errors)) {
            $this->handleErrors($errors);
        } else {
            $this->processReservations($userId, $entityIds, $quantities);
        }

        header("Location: /jazz");
        exit;
    }

    private function validateInput($userId, $entityIds, $quantities): array
    {
        $errors = [];

        if (!$userId || empty($entityIds) || empty($quantities) || !is_array($entityIds) || !is_array($quantities)) {
            $errors[] = 'Invalid user or reservation data.';
        }

        foreach ($entityIds as $artistEventId) {
            if (!isset($quantities[$artistEventId]) || !is_numeric($quantities[$artistEventId])) {
                $errors[] = "Invalid quantity for artist event ID: $artistEventId";
            }
        }

        return $errors;
    }

    private function handleErrors(array $errors): void
    {
        foreach ($errors as $error) {
            $this->flashHelper->setFlashMessage('error', $error);
        }
    }

    private function processReservations($userId, $entityIds, $quantities): void
    {
        foreach ($entityIds as $artistEventId) {
            $numberOfPeople = (int)($quantities[$artistEventId]);
            try {
                $result = $this->reservationService->artistReservationConfirm($userId, [$artistEventId], $numberOfPeople);
                if (!$result) {
                    $this->flashHelper->setFlashMessage('error', 'There was a problem confirming your reservation.');
                    return;
                }
            } catch (Exception $e) {
                $this->flashHelper->setFlashMessage('error', $e->getMessage());
                return;
            }
        }

        $this->flashHelper->setFlashMessage('success', 'Reservation confirmed!');
    }
}
