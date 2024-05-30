<?php
namespace App\Models;

class PaymentStatus
{
    public int $paymentStatusId;
    public string $name;

    public function getPaymentStatusId(): int
    {
        return $this->paymentStatusId;
    }

    public function setPaymentStatusId(int $paymentStatusId): void
    {
        $this->paymentStatusId = $paymentStatusId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    
}