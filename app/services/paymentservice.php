<?php

namespace App\Services;

use App\Repositories\PaymentRepository;


class PaymentService
{
    private PaymentRepository $paymentRepository;

    public function __construct()
    {
        $this->paymentRepository = new PaymentRepository();
    }

    public function createPayment($checkout, $totalPrice): void
    {
        $this->paymentRepository->createPayment($checkout, $totalPrice);
    }

    public function createOrder($eventIds)
    {
        $this->paymentRepository->createOrder($eventIds);
    }

    public function updateStatus($eventIds)
    {
        $this->paymentRepository->updateStatus($eventIds);
    }

    public function updatePaymentsIdInEvents($eventIds)
    {
        $this->paymentRepository->updatePaymentsIdInEvents($eventIds);
    }

    public function getPaymentIdByEventId($eventId)
    {
        return $this->paymentRepository->getPaymentIdByEventId($eventId);
    }
    
    public function getPaymentStatusByEventId($eventId)
    {
        return $this->paymentRepository->getPaymentStatusByEventId($eventId);
    }










    

  
    





}
