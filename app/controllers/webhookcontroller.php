<?php

namespace App\Controllers;

use App\Services\PaymentService;
use App\Services\OrderService;
use App\Services\PDFService;
use App\Services\MailerService;
use App\Services\UserService;
use App\Services\TicketService;
use App\Services\PersonalProgramService;

class WebHookController extends Controller
{
    private PaymentService $paymentService;
    private OrderService $orderService;
    private PDFService $pdfService;
    private MailerService $mailerService;
    private UserService $userService;
    private TicketService $ticketService;
    private PersonalProgramService $personalProgramService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->orderService = new OrderService();
        $this->pdfService = new PDFService();
        $this->mailerService = new MailerService();
        $this->userService = new UserService();
        $this->ticketService = new TicketService();
        $this->personalProgramService = new PersonalProgramService();
    }

    public function index()
    {
        require '../vendor/autoload.php';

        $stripe = new \Stripe\StripeClient('sk_test_...');
        $endpoint_secret = 'whsec_7c47c56fc3831655d861a6d357297d97f1a720f91a9221c6eed7df273fd4da90';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            error_log('Unexpected webhook payload: ' . $e->getMessage());
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            error_log('Webhook signature verification failed: ' . $e->getMessage());
            http_response_code(400);
            exit();
        }

        // DUHA-NOTE
        // Handle the event
        // error_log(print_r($_REQUEST, true));
        switch ($event->type) {
            case 'checkout.session.completed':

                $metadata = $event->data->object->metadata;

                $eventIds = json_decode($metadata['eventIds'], true);               

                // update paymentid in events tabel
                $this->paymentService->updatePaymentsIdInEvents($eventIds);

                // update paymentstatusid in payments tabel
                $this->paymentService->updateStatus($eventIds);
              
                // maak hier de order aan in de Orders tabel
                $orderId = $this->orderService->createOrder($eventIds);

                //maak hier de tickets aan in de Tickets tabel
                $this->ticketService->createTickets($orderId);

                // stuur een mail met de factuur en tickets
                $user = $this->userService->getUserById($this->personalProgramService->getEventById($eventIds[0])['userId']);
                $paymentId = $this->paymentService->getPaymentIdByEventId($eventIds[0]);
                $attachments = [];
                $attachments[] = $this->pdfService->generateInvoice($orderId)->Output("S", "invoice.pdf");
                $attachments[] = $this->pdfService->generateTickets($paymentId)->Output("S", "tickets.pdf");
                $this->mailerService->sendEmailWithAttachments($user->getEmail(), "The Festival Purchase", "Thank you for your purchase at The Festival. You can view your invoice and tickets in the provided attachments.", $attachments);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}

