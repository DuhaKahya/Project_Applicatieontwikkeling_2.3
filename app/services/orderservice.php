<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    private OrderRepository $orderRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }

    public function getOrderById($orderId)
    {
        return $this->orderRepository->getOrderById($orderId);
    }

    public function createOrder($eventIds)
    {
        return $this->orderRepository->createOrder($eventIds);
    }

    public function getTotalPriceByPaymentId($paymentId)
    {
        return $this->orderRepository->getTotalPriceByPaymentId($paymentId);
    }

   




    

  
    





}
