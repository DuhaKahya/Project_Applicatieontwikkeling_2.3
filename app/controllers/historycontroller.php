<?php

namespace App\Controllers;
use App\Repositories\HistoryRepository;
use App\Services\HistoryService;

class HistoryController extends Controller
{
    private HistoryService $historyService;
    function __construct()
    {
        $this->historyService = new HistoryService();
    }

    public function index(): void
    {
        $historyLocations = $this->historyService->getAllHistoryLocations();
        $historyTours = $this->historyService->getAllHistoryTours();
        $displayableHistoryTours = $this->displayHistoryTours($historyTours);
        require_once __DIR__ . '/../views/home/history.php';
    }

    public function detailPage(): void
    {
        $locationId = htmlspecialchars($_GET['id']);
        if (!isset($locationId) || !is_numeric($locationId)) {
            header('Location: /history');
            exit;
        }
        $historyLocation = $this->historyService->getHistoryLocationById($locationId);
        if ($historyLocation == null) {
            header('Location: /history');
            exit;
        }
        require_once __DIR__ . '/../views/history/detailPage.php';
    }

    public function addTour(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $historyTours = $this->historyService->getAllHistoryTours();
            $displayableHistoryTours = $this->displayHistoryTours($historyTours);
            $encodedHistoryTours = json_encode($historyTours);
            require_once __DIR__ . '/../views/history/addTour.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourId = htmlspecialchars($_POST['tourId']);
            $participants = intval(htmlspecialchars($_POST['amountOfPeople']));
            $existingParticipants = $this->historyService->amountOfParticipants($tourId);
            $tour = $this->historyService->getHistoryTourById($tourId);
            if ($participants + $existingParticipants > $tour->getMaxParticipants()) {
                header('Location: /history/addTour');
                exit;
            }
            else {
                $this->historyService->addHistoryEvent($tourId, $participants);
                header('Location: /history');
                exit;
            }
        }
    }

    private function displayHistoryTours($historyTours): array
    {
        $displayableHistoryTours = [];
        foreach ($historyTours as $historyTour) {
            $displayableHistoryTours[$historyTour->getLanguage()][$historyTour->getStartDate()][] = $historyTour;
        }
        return $displayableHistoryTours;
    }
}