<?php
namespace App\Services;
use Fpdf\Fpdf;

require '../vendor/fpdf/fpdf/src/fpdf/fpdf.php';
define('EURO', chr(128));

class PDFService
{
    private UserService $userService;
    private OrderService $orderService;
    private PersonalProgramService $personalProgramService;
    private TicketService $ticketService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->orderService = new OrderService();
        $this->personalProgramService = new PersonalProgramService();
        $this->ticketService = new TicketService();
    }

    public function generateInvoice($orderId): Fpdf
    {
        $order = $this->orderService->getOrderById($orderId);
        $events = $this->personalProgramService->getEventsByPaymentId($order['paymentId']);
        $user = $this->userService->getUserById($events[0]['userId']);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('../public/images/haarlem-logo.png', 10, 5, 40);
        $pdf->ln(25);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Invoice');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->ln();

        $pdf->Cell(100, 5, "Order Number: " . $order['orderId']);
        $pdf->Ln();
        $pdf->Cell(100, 5, "Date: " . date("m-d-Y"));
        $pdf->Ln();
        $pdf->Cell(100, 5, "Name: " . $user->getFirstName() . " " . $user->getLastName());
        $pdf->Ln();
        $pdf->Cell(100, 5, "Phone: " . $user->getPhoneNumber());
        $pdf->Ln();
        $pdf->Cell(100, 5, "Address: " . $user->getAddress() . " " . $user->getHouseNumber() . ", " . $user->getPostalCode());
        $pdf->Ln();
        $pdf->Cell(100, 5, "Email: " . $user->getEmail());

        $pdf->Ln(10);
        $subTotal9 = 0;
        $subTotal21 = 0;
        $vat9 = 0;
        $vat21 = 0;

        $artistEvents = new \ArrayObject();
        $historyEvents = new \ArrayObject();
        $restaurantEvents = new \ArrayObject();

        foreach ($events as $event) {
            if ($event['historyEventId'] !== null) {
                $historyEvents[] = $this->personalProgramService->getHistoryEventById($event['eventId']);
            } elseif ($event['restaurantEventId'] !== null) {
                $restaurantEvents[] = $this->personalProgramService->getRestaurantEventById($event['eventId']);
            } elseif ($event['artistEventId'] !== null) {
                $artistEvents[] = $this->personalProgramService->getArtistEventById($event['eventId']);
            }
        }

        foreach ($historyEvents as $historyEvent) {
            $price = $historyEvent['price'] * $historyEvent['participants'] - floor($historyEvent['participants'] / 4) * 10;
            $pdf->Cell(100, 5, "Tour Haarlem", 'LTR');
            $pdf->Ln();
            $pdf->Cell(100, 5, "Price (ex 21% VAT): " . $this->displayPrice($price), 'LRB');
            $pdf->Ln();
            $subTotal21 += $price;
            $vat21 += $price * 0.21;
        }

        foreach ($restaurantEvents as $restaurantEvent) {
            $price = 10 * ($restaurantEvent['adults'] + $restaurantEvent['children']);
            $pdf->Cell(100, 5, "Restaurant: " . $restaurantEvent['name'], 'LTR');
            $pdf->Ln();
            $pdf->Cell(100, 5, "Price (ex 9% VAT): " . $this->displayPrice($price), 'LRB');
            $pdf->Ln();
            $subTotal9 += $price;
            $vat9 += $price * 0.09;
        }

        foreach ($artistEvents as $artistEvent) {
            $price = $artistEvent['price'] * $artistEvent['ticketsPurchased'];
            $pdf->Cell(100, 5, "Jazz festival: " . $artistEvent['name'], 'LTR');
            $pdf->Ln();
            $pdf->Cell(100, 5, "Price (ex 9% VAT): " . $this->displayPrice($price), 'LRB');
            $pdf->Ln();
            $subTotal9 += $price;
            $vat9 += $price * 0.09;
        }

        $pdf->Ln();
        if ($vat9 > 0) {
            $pdf->Cell(100, 5, "Sub Total (ex 9% VAT): " . $this->displayPrice($subTotal9));
            $pdf->Ln();
            $pdf->Cell(100, 5, "VAT 9%: " . $this->displayPrice($vat9));
            $pdf->Ln(10);
        }
        if ($vat21 > 0) {
            $pdf->Cell(100, 5, "Sub Total (ex 21% VAT): " . $this->displayPrice($subTotal21));
            $pdf->Ln();
            $pdf->Cell(100, 5, "VAT 21%: " . $this->displayPrice($vat21));
            $pdf->Ln(10);
        }
        $pdf->Cell(100, 5, "Total: " . $this->displayPrice($subTotal9 + $vat9 + $subTotal21 + $vat21));
        $pdf->Ln(10);
        $pdf->Cell(100, 5, "Payment Date: " . date("m-d-Y", strtotime($order['date'])));

        return $pdf;
    }

    public function generateTickets($paymentId): Fpdf
    {
        $tickets = $this->ticketService->getTicketsByPaymentId($paymentId);

        $pdf = new FPDF();
        for ($i = 0; $i < count($tickets); $i++) {
            $ticket = $tickets[$i];
            $event = $this->personalProgramService->getEventById($ticket['eventId']);
            $user = $this->userService->getUserById($event['userId']);

            $pdf->AddPage();
            $pdf->Image('../public/images/haarlem-logo.png', 10, 5, 40);
            $pdf->ln(25);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(40, 10, 'Ticket');

            $pdf->ln();
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(100, 5, "Name: " . $user->getFirstName() . " " . $user->getLastName());
            $pdf->Ln();
            if ($event['historyEventId'] !== null) {
                $historyEvent = $this->personalProgramService->getHistoryEventById($event['eventId']);
                $pdf->Cell(100, 5, "Tour Haarlem");
                $pdf->Ln();
                $pdf->Cell(100, 5, "Language: " . $historyEvent['name']);
                $pdf->Ln();
                $pdf->Cell(100, 5, "Date: " . date("m-d-Y", strtotime($historyEvent['tourStartTime'])));
                $pdf->Ln();
                $pdf->Cell(100, 5, "Time: " . date("H:i", strtotime($historyEvent['tourStartTime'])));
                $pdf->Ln();
                $pdf->Cell(100, 5, "Tour Guide: " . $historyEvent['tourGuide']);
            } elseif ($event['artistEventId'] !== null) {
                $artistEvent = $this->personalProgramService->getArtistEventById($event['eventId']);
                $pdf->Cell(100, 5, "Jazz festival with " . $artistEvent['name']);
                $pdf->Ln();
                $pdf->Cell(100, 5, "Location: " . $artistEvent['location']);
                $pdf->Ln();
                $pdf->Cell(100, 5, "Date: " . date("m-d-Y", strtotime($artistEvent['concertStartTime'])));
                $pdf->Ln();
                $pdf->Cell(100, 5, "Time: " . date("H:i", strtotime($artistEvent['concertStartTime'])));
            } elseif ($event['restaurantEventId'] !== null) {
                $restaurantEvent = $this->personalProgramService->getRestaurantEventById($event['eventId']);
                $pdf->Cell(100, 5, "Restaurant " . $restaurantEvent['name']);
                $pdf->Ln();
                $pdf->Cell(100, 5, "Location: " . $restaurantEvent['location']);
                $pdf->Ln();
                $pdf->Cell(100, 5, "Date: " . date("m-d-Y", strtotime($restaurantEvent['dinnerStartTime'])));
                $pdf->Ln();
                $pdf->Cell(100, 5, "Time: " . date("H:i", strtotime($restaurantEvent['dinnerStartTime'])));
            }

            $pdf->Ln(10);
            $pdf->Cell(100, 5, "QR Code: ");
            $pdf->Ln();

            $qrCode = 'http://localhost/scanqr?id=' . $ticket['ticketId'] . '&token=' . $ticket['token'];
            $qrCode = urlencode($qrCode);
            $url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $qrCode;
            file_put_contents('../public/images/QRcodes/qr-code' . $i . '.png', file_get_contents($url));
            $pdf->Image('../public/images/QRcodes/qr-code' . $i . '.png', 10, 80, 40);
        }
        return $pdf;
    }

    private function displayPrice(float $price): string
    {
        return EURO . number_format($price, 2);
    }
}