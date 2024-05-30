<?php

namespace App\Repositories;

class TicketRepository extends Repository
{
    public function createTicket($eventId, $paymentId): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO Tickets (eventId, paymentId, token)
            VALUES (:eventId, :paymentId, :token)
        ");
        //$token = "1234567890";
        $token = bin2hex(random_bytes(5));
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }

    public function getTicketsByPaymentId($paymentId) : array
    {
        $stmt = $this->connection->prepare("
            SELECT ticketId, eventId, paymentId, token
            FROM Tickets
            WHERE paymentId = :paymentId
        ");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}