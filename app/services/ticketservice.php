<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Services\OrderService;
use App\Services\PersonalProgramService;

class TicketService
{
    private TicketRepository $ticketRepository;
    private OrderService $orderService;
    private PersonalProgramService $personalProgramService;

    public function __construct()
    {
        $this->ticketRepository = new TicketRepository();
        $this->orderService = new OrderService();
        $this->personalProgramService = new PersonalProgramService();
    }

    public function createTickets($orderId): void
    {
        $order = $this->orderService->getOrderById($orderId);
        $paymentId = $order['paymentId'];
        $events = $this->personalProgramService->getEventsByPaymentId($paymentId);
        foreach ($events as $event) {
            $quantity = 0;
            if ($event['historyEventId'] !== null) {
                $quantity = $this->personalProgramService->getHistoryEvent($event['historyEventId'])['participants'];
            } elseif ($event['restaurantEventId'] !== null) {
                $restaurantEvent = $this->personalProgramService->getRestaurantEvent($event['restaurantEventId']);
                $quantity = $restaurantEvent['adults'] + $restaurantEvent['children'];
            } elseif ($event['artistEventId'] !== null) {
                $quantity = $this->personalProgramService->getArtistEventById($event['eventId'])['ticketsPurchased'];
            }
            for ($i = 0; $i < $quantity; $i++) {
                $this->ticketRepository->createTicket($event['eventId'], $paymentId);
            }
        }
    }

    public function getTicketsByPaymentId($paymentId): array
    {
        return $this->ticketRepository->getTicketsByPaymentId($paymentId);
    }
}