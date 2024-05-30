<?php

namespace App\Repositories;
use App\Models\HistoryLocation;
use App\Models\HistoryTour;

class HistoryRepository extends Repository
{
    public function getAllHistoryLocations() : bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT historyLocationId, name, imagePath
            FROM HistoryLocation
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, HistoryLocation::class);
    }

    public function getHistoryLocationById(int $id)
    {
        $stmt = $this->connection->prepare("
            SELECT historyLocationId, name, imagePath, aboutImagePath, historyImagePath, about, history
            FROM HistoryLocation
            WHERE historyLocationId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(HistoryLocation::class);
    }

    public function createHistoryLocation(string $locationName, string $imagePath, string $aboutImagePath, string $historyImagePath, string $about, string $history) : bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO HistoryLocation (name, imagePath, aboutImagePath, historyImagePath, about, history)
            VALUES (:name, :imagePath, :aboutImagePath, :historyImagePath, :about, :history)
        ");
        $stmt->bindParam(':name', $locationName);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->bindParam(':aboutImagePath', $aboutImagePath);
        $stmt->bindParam(':historyImagePath', $historyImagePath);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':history', $history);
        return $stmt->execute();
    }

    public function updateHistoryLocation(int $id, string $locationName, string $imagePath, string $aboutImagePath, string $historyImagePath, string $about, string $history) : bool
    {
        $stmt = $this->connection->prepare("
            UPDATE HistoryLocation
            SET name = :name, imagePath = :imagePath, aboutImagePath = :aboutImagePath, historyImagePath = :historyImagePath, about = :about, history = :history
            WHERE historyLocationId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $locationName);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->bindParam(':aboutImagePath', $aboutImagePath);
        $stmt->bindParam(':historyImagePath', $historyImagePath);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':history', $history);
        return $stmt->execute();
    }

    public function deleteHistoryLocation(int $id) : bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM HistoryLocation
            WHERE historyLocationId = :id
        ");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAllHistoryTours() : bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT historyTourId, Language.name, tourStartTime, maxParticipants, price, tourGuide, 
                    COALESCE((
                        SELECT SUM(participants)
                        FROM HistoryEvent
                        WHERE HistoryEvent.historyTourId = HistoryTour.historyTourId
                    ), 0) AS totalParticipants
            FROM HistoryTour
            JOIN Language ON HistoryTour.languageId = Language.languageId
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, HistoryTour::class);
    }

    public function getAllLanguages() : bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT languageId, name
            FROM Language
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getHistoryTourById(int $id)
    {
        $stmt = $this->connection->prepare("
            SELECT historyTourId, Language.name, tourStartTime, maxParticipants, price, tourGuide
            FROM HistoryTour
            JOIN Language ON HistoryTour.languageId = Language.languageId
            WHERE historyTourId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(HistoryTour::class);
    }

    public function createHistoryTour(int $languageId, string $startDateTime, int $maxParticipants, float $price, string $tourGuide): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO HistoryTour (languageId, tourStartTime, maxParticipants, price, tourGuide)
            VALUES (:languageId, :startDateTime, :maxParticipants, :price, :tourGuide)
        ");
        $stmt->bindParam(':languageId', $languageId);
        $stmt->bindParam(':startDateTime', $startDateTime);
        $stmt->bindParam(':maxParticipants', $maxParticipants);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':tourGuide', $tourGuide);
        return $stmt->execute();
    }

    public function updateHistoryTour(int $id, string $languageId, string $startDateTime, int $maxParticipants, float $price, string $tourGuide): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE HistoryTour
            SET languageId = :languageId, tourStartTime = :startDateTime, maxParticipants = :maxParticipants, price = :price, tourGuide = :tourGuide
            WHERE historyTourId = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':languageId', $languageId);
        $stmt->bindParam(':startDateTime', $startDateTime);
        $stmt->bindParam(':maxParticipants', $maxParticipants);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':tourGuide', $tourGuide);
        return $stmt->execute();
    }

    public function deleteHistoryTour(int $id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM HistoryTour
            WHERE historyTourId = :id
        ");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function addHistoryEvent(int $tourId, int $participants): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO HistoryEvent (historyTourId, participants)
            VALUES (:tourId, :participants)
        ");
        $stmt->bindParam(':tourId', $tourId);
        $stmt->bindParam(':participants', $participants);

        $execute = $stmt->execute();
        $this->addTourToEvents($this->connection->lastInsertId(), $_SESSION['user_id']);
        return $execute;
    }

    private function addTourToEvents($historyEventId, $userId)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO Events (historyEventId, userId)
            VALUES (:historyEventId, :userId)
        ");
        $stmt->bindParam(':historyEventId', $historyEventId);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    public function amountOfParticipants($historyTourId) {
        $stmt = $this->connection->prepare("
            SELECT SUM(participants) as totalParticipants
            FROM HistoryEvent
            WHERE historyTourId = :historyTourId
        ");
        $stmt->bindParam(':historyTourId', $historyTourId);
        $stmt->execute();
        return $stmt->fetchColumn() ?? 0;
    }
}