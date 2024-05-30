<?php

namespace App\Repositories;

class PersonalProgramRepository extends Repository
{
    public function getEventById($eventId) : array
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM Events
            WHERE eventId = :eventId
        ");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getEventsFromUser($userId) : array
    {
        $stmt = $this->connection->prepare("
            SELECT eventId, historyEventId, restaurantEventId, artistEventId
            FROM Events
            WHERE userId = :userId
        ");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getHistoryEventById($eventId) : bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT e.eventId, he.historyEventId, he.historyTourId, ht.tourStartTime, l.name, he.participants, ht.price, ht.maxParticipants, e.paymentId, ht.tourGuide, 
                (SELECT SUM(participants)
                FROM HistoryEvent
                WHERE historyTourId = he.historyTourId) as maxQuantity
            FROM Events as e
            JOIN HistoryEvent as he ON e.historyEventId = he.historyEventId
            JOIN HistoryTour as ht ON he.HistoryTourId = ht.historyTourId
            JOIN Language as l ON ht.LanguageId = l.LanguageId
            WHERE e.eventId = :eventId
        ");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getRestaurantEventById($eventId) : bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT e.eventId, re.restaurantEventId, r.restaurantId, r.name, re.adults, re.children, rd.reservationDayId, rd.day, rs.restaurantSessionId, rs.startTime, rs.endTime, r.price, e.paymentId
            FROM Events as e
            JOIN RestaurantEvent as re ON e.restaurantEventId = re.restaurantEventId
            JOIN ReservationDay as rd ON re.reservationDayId = rd.reservationDayId
            JOIN RestaurantSessions as rs ON re.restaurantSessionId = rs.restaurantSessionId
            JOIN Restaurant as r ON re.restaurantId = r.restaurantId
            WHERE e.eventId = :eventId
        ");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getArtistEventById($eventId) : bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT e.eventId, ae.artistEventId, a.name, ae.concertStartTime, ae.concertEndTime, ae.price, e.paymentId, ael.name as location, ae.amountOfPeople, ael.amount, 
                   (SELECT uaet.ticketsPurchased 
                    FROM UserArtistEventTickets as uaet 
                    WHERE uaet.userId = e.userId AND uaet.artistEventId = ae.artistEventId) as ticketsPurchased
            FROM Events as e
            JOIN ArtistEvents as ae ON e.artistEventId = ae.artistEventId
            JOIN Artists as a ON ae.artistId = a.artistId
            JOIN ArtistEventLocations as ael ON ae.artistEventLocationId = ael.artistEventLocationId
            WHERE e.eventId = :eventId
        ");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getHistoryEvent($historyEventId) : array
    {
        $stmt = $this->connection->prepare("
            SELECT he.historyEventId, he.historyTourId, ht.tourStartTime, l.name, he.participants, ht.price
            FROM HistoryEvent as he
            JOIN HistoryTour as ht ON he.HistoryTourId = ht.historyTourId
            JOIN Language as l ON ht.LanguageId = l.LanguageId
            WHERE historyEventId = :historyEventId
        ");
        $stmt->bindParam(':historyEventId', $historyEventId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getRestaurantEvent($restaurantEventId) : array
    {
        $stmt = $this->connection->prepare("
            SELECT re.restaurantEventId, r.name, re.adults, re.children, rd.day, rs.startTime, rs.endTime, r.price
            FROM RestaurantEvent as re
            JOIN ReservationDay as rd ON re.reservationDayId = rd.reservationDayId
            JOIN RestaurantSessions as rs ON re.restaurantSessionId = rs.restaurantSessionId
            JOIN Restaurant as r ON re.restaurantId = r.restaurantId
            WHERE restaurantEventId = :restaurantEventId
        ");
        $stmt->bindParam(':restaurantEventId', $restaurantEventId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function removeEvent($eventId, $eventType, $subEventId) : void
    {
        $stmt = $this->connection->prepare("
            DELETE FROM Events
            WHERE eventId = :eventId
        ");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        if ($eventType === 'history') {
            $stmt = $this->connection->prepare("
                DELETE FROM HistoryEvent
                WHERE historyEventId = :subEventId
            ");
        } elseif ($eventType === 'yummy') {
            $stmt = $this->connection->prepare("
                DELETE FROM RestaurantEvent
                WHERE restaurantEventId = :subEventId
            ");
        } elseif ($eventType === 'jazz') {
            $stmt = $this->connection->prepare("
                DELETE FROM UserArtistEventTickets
                WHERE artistEventId = :subEventId AND userId = :userId
            ");
        }
        $stmt->bindParam(':subEventId', $subEventId);
        $stmt->bindParam(':userId', $_SESSION['user_Id']);
        $stmt->execute();
    }

    public function getEventsByPaymentId($paymentId): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM Events
            WHERE paymentId = :paymentId
        ");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function changeRestaurantQuantity($restaurantEventId, $adults, $children): void
    {
        $stmt = $this->connection->prepare("
            UPDATE RestaurantEvent
            SET adults = :adults, children = :children
            WHERE restaurantEventId = :restaurantEventId
        ");
        $stmt->bindParam(':restaurantEventId', $restaurantEventId);
        $stmt->bindParam(':adults', $adults);
        $stmt->bindParam(':children', $children);
        $stmt->execute();
    }

    public function changeHistoryQuantity($historyEventId, $participants): void
    {
        $stmt = $this->connection->prepare("
            UPDATE HistoryEvent
            SET participants = :participants
            WHERE historyEventId = :historyEventId
        ");
        $stmt->bindParam(':historyEventId', $historyEventId);
        $stmt->bindParam(':participants', $participants);
        $stmt->execute();
    }

    public function changeArtistQuantity($artistEventId, $ticketsPurchased, $userId): void
    {
        $stmt = $this->connection->prepare("
            UPDATE UserArtistEventTickets
            SET ticketsPurchased = :ticketsPurchased
            WHERE artistEventId = :artistEventId AND userId = :userId
        ");
        $stmt->bindParam(':artistEventId', $artistEventId);
        $stmt->bindParam(':ticketsPurchased', $ticketsPurchased);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}