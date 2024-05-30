<?php

namespace App\Repositories;

use App\Models\Order;

use PDO;

class OrderRepository extends Repository
{

    public function getAllOrders(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM Orders
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Order::class);
    }

    public function getOrderById($orderId)
    {
        $stmt = $this->connection->prepare("
            SELECT orderId, paymentId, date
            FROM Orders
            WHERE orderId = :orderId
        ");
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // DUHA-NOTE
    public function createOrder($eventIds): bool|string
    {
        // Haal de paymentId op voor het eerste eventId in de array
        $stmt = $this->connection->prepare("
            SELECT paymentId
            FROM Events
            WHERE eventId = :eventId
        ");
        $stmt->bindParam(':eventId', $eventIds[0]);
        $stmt->execute();
        $paymentIdRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $paymentId = $paymentIdRow['paymentId'];

        // Maak een order aan met de gevonden paymentId
        $stmt = $this->connection->prepare("
            INSERT INTO Orders (paymentId)
            VALUES (:paymentId)
        ");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function getTotalPriceByPaymentId($paymentId)
    {
        $stmt = $this->connection->prepare("
            SELECT totalPrice
            FROM Payments
            WHERE paymentId = :paymentId
        ");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
