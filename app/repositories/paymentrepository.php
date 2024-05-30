<?php

namespace App\Repositories;

use PDO;

class PaymentRepository extends Repository
{

    public function createPayment($checkout, $totalPrice): void
    {
    
        // Prepare the SQL statement
        $stmt = $this->connection->prepare("
            INSERT INTO Payments (session, paymentStatusId, totalPrice)
            VALUES (:checkout, 2, :totalPrice) 
        ");
    
        // Bind the parameters
        $stmt->bindParam(':checkout', $checkout);
        $stmt->bindParam(':totalPrice', $totalPrice);

        $stmt->execute();
    }
    

    
    // DUHA-NOTE
    public function updateStatus($eventIds)
    {
        // haal aan de hand van de eventIds de paymentId op uit de Events-tabel
        foreach($eventIds as $eventId) {
            $stmt = $this->connection->prepare("
                SELECT paymentId
                FROM Events
                WHERE eventId = :eventId
            ");
            $stmt->bindParam(':eventId', $eventId);
            $stmt->execute();
            $paymentIdRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $paymentId = $paymentIdRow['paymentId'];
    
            // Update de betalingsstatus in de Payments-tabel
            $stmt = $this->connection->prepare("
                UPDATE Payments
                SET paymentStatusId = 1
                WHERE paymentId = :paymentId
            ");
            $stmt->bindParam(':paymentId', $paymentId);
            $stmt->execute();
        }
    }

    // DUHA-NOTE
    public function updatePaymentsIdInEvents($eventIds)
    {
        // Haal de laatst ingevoegde paymentId op uit de Payments-tabel
        $stmt = $this->connection->prepare("
            SELECT paymentId
            FROM Payments
            ORDER BY paymentId DESC
            LIMIT 1
        ");
        $stmt->execute();
        $paymentIdRow = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Haal de paymentId op uit de fetch array
        $paymentId = $paymentIdRow['paymentId'];
    
        // Loop door de eventIds en update de paymentId in de Events-tabel
        foreach($eventIds as $eventId) {
            $stmt = $this->connection->prepare("
                UPDATE Events
                SET paymentId = :paymentId
                WHERE eventId = :eventId;
            ");
            $stmt->bindParam(':paymentId', $paymentId);
            $stmt->bindParam(':eventId', $eventId);
            $stmt->execute();
        }
    }
    

    public function getPaymentIdByEventId($eventId)
    {
        $stmt = $this->connection->prepare("
            SELECT paymentId
            FROM Events
            WHERE eventId = :eventId
        ");
        $stmt->bindValue(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Als er een rij is gevonden, geef dan de betalingsstatus terug
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['paymentId'];
        }
        
        return null;
    }

    // payment id zit in events tabel en paymentstatusid zit in payments tabel
    public function getPaymentStatusByEventId($eventId)
    {
        $stmt = $this->connection->prepare("
            SELECT p.paymentStatusId
            FROM Events e
            JOIN Payments p ON e.paymentId = p.paymentId
            WHERE e.eventId = :eventId
        ");

        $stmt->bindValue(':eventId', $eventId, PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Haal de betalingsstatus op als er een rij gevonden is
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['paymentStatusId'];
        }
        
        return null; // Return null als er geen betalingsstatus is gevonden
    }


    public function checkSession($session)
    {
        $stmt = $this->connection->prepare("
            SELECT session
            FROM Payments
            WHERE session = :session
        ");
        $stmt->bindValue(':session', $session, PDO::PARAM_STR);
        $stmt->execute();
        
        // Als er een rij is gevonden, geef dan de betalingsstatus terug
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['session'];
        }
        
        return null;
    }






    
  


    
    
}
