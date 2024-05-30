<?php

namespace App\Repositories;

use App\Models\RestaurantEvent;
use App\Models\RestaurantSessions;
use App\Models\ReservationDay;

use Exception;
use PDO;
use PDOException;

class ReservationRepository extends Repository
{

    // Restaurant Events

    public function insertRestaurantEvent(RestaurantEvent $restaurantEvent)
    {
        $sql = "
            INSERT INTO RestaurantEvent (userId, restaurantId, restaurantSessionId, reservationDayId, specificRequest, adults, children)
            VALUES (:userId, :restaurantId, :restaurantSessionId, :reservationDayId, :specificRequest, :adults, :children)";

        $stmt = $this->connection->prepare($sql);
        $userId = $restaurantEvent->getUserId();
        $restaurantId = $restaurantEvent->getRestaurantId();
        $restaurantSessionId = $restaurantEvent->getRestaurantSessionId();
        $reservationDayId = $restaurantEvent->getReservationDayId();
        $specificRequest = $restaurantEvent->getSpecificRequest();
        $adults = $restaurantEvent->getAdults();
        $children = $restaurantEvent->getChildren();

        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':restaurantSessionId', $restaurantSessionId);
        $stmt->bindParam(':reservationDayId', $reservationDayId);
        $stmt->bindParam(':specificRequest', $specificRequest);
        $stmt->bindParam(':adults', $adults);
        $stmt->bindParam(':children', $children);

        $execute = $stmt->execute();
        $this->addReservationToEvents($this->connection->lastInsertId(), $_SESSION['user_id']);
        return $execute;
    }

    // Reservations

    private function addReservationToEvents($restaurantEventId, $userId)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO Events (restaurantEventId, userId)
            VALUES (:restaurantEventId, :userId)
        ");

        $stmt->bindParam(':restaurantEventId', $restaurantEventId);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    // return restaurant event by id

    public function getAllReservations(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantEventId, userId, restaurantId, restaurantSessionId, reservationDayId, specificRequest, adults, children, status
            FROM RestaurantEvent
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, RestaurantEvent::class);
    }

    public function getReservationById(int $id): bool|RestaurantEvent
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantEventId, userId, restaurantId, restaurantSessionId, reservationDayId, specificRequest, adults, children, status
            FROM RestaurantEvent
            WHERE restaurantEventId = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(RestaurantEvent::class);
    }

    public function createReservation($userId, $restaurantId, $restaurantSessionId, $reservationDayId, $specificRequest, $adults, $children): bool
    {
        $stmt = $this->connection->prepare("
            INSERT INTO RestaurantEvent (userId, restaurantId, restaurantSessionId, reservationDayId, specificRequest, adults, children)
            VALUES (:userId, :restaurantId, :restaurantSessionId, :reservationDayId, :specificRequest, :adults, :children)
        ");

        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':restaurantSessionId', $restaurantSessionId);
        $stmt->bindParam(':reservationDayId', $reservationDayId);
        $stmt->bindParam(':specificRequest', $specificRequest);
        $stmt->bindParam(':adults', $adults);
        $stmt->bindParam(':children', $children);

        $execute = $stmt->execute();
        $this->addReservationToEvents($this->connection->lastInsertId(), $_SESSION['user_id']);
        return $execute;
    }

    public function updateReservation($restaurantEventId, $userId, $restaurantId, $restaurantSessionId, $reservationDayId, $specificRequest, $adults, $children, $status): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE RestaurantEvent
            SET 
                userId = :userId,
                restaurantId = :restaurantId, 
                restaurantSessionId = :restaurantSessionId, 
                reservationDayId = :reservationDayId, 
                specificRequest = :specificRequest, 
                adults = :adults, 
                children = :children, 
                status = :status
            WHERE restaurantEventId = :restaurantEventId
        ");

        $stmt->bindParam(':restaurantEventId', $restaurantEventId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':restaurantSessionId', $restaurantSessionId);
        $stmt->bindParam(':reservationDayId', $reservationDayId);
        $stmt->bindParam(':specificRequest', $specificRequest);
        $stmt->bindParam(':adults', $adults);
        $stmt->bindParam(':children', $children);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }


    // Sessions

    public function deleteReservation(int $id): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM RestaurantEvent
            WHERE restaurantEventId = :id
        ");

        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAllSessions(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantSessionId, startTime, endTime
            FROM RestaurantSessions
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, RestaurantSessions::class);
    }

    // Days

    public function getIdByStartTimeAndEndTime(string $startTime, string $endTime): int
    {
        $stmt = $this->connection->prepare("
            SELECT restaurantSessionId
            FROM RestaurantSessions
            WHERE startTime = :startTime 
              AND endTime = :endTime
        ");

        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        $stmt->execute();

        // return the id as an integer
        return $stmt->fetchColumn();
    }

    public function getAllDays(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT reservationDayId, day
            FROM ReservationDay
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, ReservationDay::class);

    }

    public function getIdByDay(string $day): int
    {
        $stmt = $this->connection->prepare("
            SELECT reservationDayId
            FROM ReservationDay
            WHERE day = :day
        ");

        $stmt->bindParam(':day', $day);
        $stmt->execute();

        // return the id as an integer
        return $stmt->fetchColumn();
    }

    public function artistReservationConfirm($userId, $artistEventIds, $numberOfPeople)
    {
        try {
            $this->connection->beginTransaction();

            foreach ($artistEventIds as $artistEventId) {
                // $_SESSION['selectedEntitiesDetails'] holds the event details
                $eventName = "";
                foreach ($_SESSION['selectedEntitiesDetails'] as $selectedEntity) {
                    if ($selectedEntity['artistEventId'] == $artistEventId) {
                        $eventName = $selectedEntity['artistName'];
                        break;
                    }
                }

                $currentReservationCount = $this->getCurrentReservationCount($artistEventId);
                $eventCapacity = $this->getEventCapacity($artistEventId);
                $reservationLimit = floor(0.9 * $eventCapacity);

                if ($currentReservationCount + $numberOfPeople > $reservationLimit) {
                    // If the new reservation exceeds 90% of the total capacity, rollback, set flash message, and redirect
                    $this->connection->rollBack();
                    $this->flashHelper->setFlashMessage('error', "Cannot reserve more than 90% of the seats for the event: $eventName. No more tickets available.");
                    header("Location: /reservation");
                    exit;
                }

                $stmt = $this->connection->prepare("
                    INSERT INTO Events (userId, artistEventId) 
                    VALUES (:userId, :artistEventId)
                ");
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':artistEventId', $artistEventId);
                $stmt->execute();

                $updateArtistEventStmt = $this->connection->prepare("
                UPDATE ArtistEvents
                SET amountOfPeople = amountOfPeople + :numberOfPeople
                WHERE artistEventId = :artistEventId
            ");
                $updateArtistEventStmt->bindParam(':numberOfPeople', $numberOfPeople);
                $updateArtistEventStmt->bindParam(':artistEventId', $artistEventId);
                $updateArtistEventStmt->execute();

                $checkTicketStmt = $this->connection->prepare("
                    SELECT id, ticketsPurchased
                    FROM UserArtistEventTickets
                    WHERE userId = :userId 
                      AND artistEventId = :artistEventId
                ");
                $checkTicketStmt->execute([
                    ':userId' => $userId,
                    ':artistEventId' => $artistEventId
                ]);
                $ticketRecord = $checkTicketStmt->fetch(PDO::FETCH_ASSOC);

                if ($ticketRecord) {
                    // Update existing record
                    $newTickets = $ticketRecord['ticketsPurchased'] + $numberOfPeople;
                    $updateTicketStmt = $this->connection->prepare("
                    UPDATE UserArtistEventTickets
                    SET ticketsPurchased = :newTickets
                    WHERE id = :id
                ");
                    $updateTicketStmt->execute([
                        ':newTickets' => $newTickets,
                        ':id' => $ticketRecord['id']
                    ]);
                } else {
                    $insertTicketStmt = $this->connection->prepare("
                        INSERT INTO UserArtistEventTickets (userId, artistEventId, ticketsPurchased)
                        VALUES (:userId, :artistEventId, :ticketsPurchased)
                    ");
                    $insertTicketStmt->execute([
                        ':userId' => $userId,
                        ':artistEventId' => $artistEventId,
                        ':ticketsPurchased' => $numberOfPeople
                    ]);
                }
            }

            // Commit the transaction
            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            // Rollback transaction on error
            $this->connection->rollBack();
            $this->flashHelper->setFlashMessage('error', 'There was a problem confirming your reservation.');
            header("Location: /reservation");
            exit();
        }
    }

    public function getCurrentReservationCount($artistEventId): int
    {
        try{
            $stmt = $this->connection->prepare("
                SELECT amountOfPeople
                FROM ArtistEvents
                WHERE artistEventId = :artistEventId
            ");
            $stmt->bindParam(':artistEventId', $artistEventId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['amountOfPeople'];
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'There was a problem confirming your reservation.');
            header("Location: /reservation");
            exit();
        }
    }

    public function getEventCapacity($artistEventId): int
    {
        $stmt = $this->connection->prepare("
            SELECT ArtistEventLocations.amount AS capacity
            FROM ArtistEvents
                JOIN ArtistEventLocations 
                    ON ArtistEvents.artistEventLocationId = ArtistEventLocations.artistEventLocationId
            WHERE ArtistEvents.artistEventId = :artistEventId
        ");
        $stmt->bindParam(':artistEventId', $artistEventId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['capacity'];
    }
}
