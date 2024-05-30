<?php

namespace App\Services;

use App\Repositories\HistoryRepository;

class HistoryService
{
    private HistoryRepository $historyRepository;

    public function __construct()
    {
        $this->historyRepository = new HistoryRepository();
    }

    public function getAllHistoryLocations(): bool|array
    {
        return $this->historyRepository->getAllHistoryLocations();
    }

    public function getHistoryLocationById(int $id)
    {
        return $this->historyRepository->getHistoryLocationById($id);
    }

    public function createHistoryLocation(string $locationName, string $imagePath, string $aboutImagePath, string $historyImagePath, string $about, string $history): bool
    {
        return $this->historyRepository->createHistoryLocation($locationName, $imagePath, $aboutImagePath, $historyImagePath, $about, $history);
    }

    public function updateHistoryLocation(int $id, string $locationName, string $imagePath, string $aboutImagePath, string $historyImagePath, string $about, string $history): bool
    {
        return $this->historyRepository->updateHistoryLocation($id, $locationName, $imagePath, $aboutImagePath, $historyImagePath, $about, $history);
    }

    public function deleteHistoryLocation(int $id): bool
    {
        return $this->historyRepository->deleteHistoryLocation($id);
    }

    public function getAllHistoryTours(): bool|array
    {
        return $this->historyRepository->getAllHistoryTours();
    }

    public function getAllLanguages(): bool|array
    {
        return $this->historyRepository->getAllLanguages();
    }

    public function getHistoryTourById(int $id)
    {
        return $this->historyRepository->getHistoryTourById($id);
    }

    public function createHistoryTour(int $languageId, string $startDateTime, int $maxParticipants, float $price, string $tourGuide): bool
    {
        return $this->historyRepository->createHistoryTour($languageId, $startDateTime, $maxParticipants, $price, $tourGuide);
    }

    public function updateHistoryTour(int $id, int $languageId, string $startDateTime, int $maxParticipants, float $price, string $tourGuide): bool
    {
        return $this->historyRepository->updateHistoryTour($id, $languageId, $startDateTime, $maxParticipants, $price, $tourGuide);
    }

    public function deleteHistoryTour(int $id): bool
    {
        return $this->historyRepository->deleteHistoryTour($id);
    }

    public function addHistoryEvent(int $tourId, int $participants) :bool {
        return $this->historyRepository->addHistoryEvent($tourId, $participants);
    }

    public function amountOfParticipants($historyTourId) {
        return $this->historyRepository->amountOfParticipants($historyTourId);
    }
}