<?php

namespace App\Controllers;

use App\Services\PersonalProgramService;
use App\Services\UserService;
use App\Helpers\FlashHelper;
use App\Services\PaymentService;
use App\Services\YummyService;

class PersonalProgramController extends Controller
{
    private $personalProgramService;
    private $userService;
    private $flashHelper;
    private $paymentService;
    private $yummyService;

    public function __construct()
    {
        $this->personalProgramService = new PersonalProgramService();
        $this->userService = new UserService();
        $this->flashHelper = new FlashHelper();
        $this->paymentService = new PaymentService();
        $this->yummyService = new YummyService();
    }

    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $events = $this->personalProgramService->getEventsFromUser($_SESSION['user_id']);
            $eventStatus = $this->getEventsWithPaymentStatus($events); // Gebruik de methode om de betalingsstatus op te halen

            $artistEvents = new \ArrayObject();
            $historyEvents = new \ArrayObject();
            $restaurantEvents = new \ArrayObject();
            foreach ($events as $event) {
                if ($event['historyEventId'] !== null) {
                    $historyEvent = $this->personalProgramService->getHistoryEventById($event['eventId']);
                    if ($eventStatus[$event['eventId']] !== 1) { // Controleer of de betalingsstatus niet gelijk is aan 1 (betaald)
                        $historyEvents[] = $historyEvent;
                    }
                } elseif ($event['restaurantEventId'] !== null) {
                    $restaurantEvent = $this->personalProgramService->getRestaurantEventById($event['eventId']);
                    if ($eventStatus[$event['eventId']] !== 1) { // Controleer of de betalingsstatus niet gelijk is aan 1
                        $restaurantEvent['maxQuantity'] = $this->yummyService->getAvailablePlaces($restaurantEvent['restaurantId'], $restaurantEvent['restaurantSessionId'], $restaurantEvent['reservationDayId']);
                        $restaurantEvents[] = $restaurantEvent;
                    }
                } elseif ($event['artistEventId'] !== null) {
                    $artistEvent = $this->personalProgramService->getArtistEventById($event['eventId']);
                    if ($eventStatus[$event['eventId']] !== 1) { // Controleer of de betalingsstatus niet gelijk is aan 1 (betaald)
                        $artistEvents[] = $artistEvent;
                    }
                }
            }

            require_once __DIR__ . '/../views/personalprogram/personalprogram.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['eventIds'])) {
 

                $_SESSION['eventsToBePaid'] = htmlspecialchars($_POST['eventIds']);

                // Split the string into an array of event IDs
                $eventIds = explode(',', htmlspecialchars($_POST['eventIds']));

                // Voorbereiding van de line items voor Stripe Checkout
                $lineItems = [];

                // Loop door de geselecteerde evenementen en voeg ze toe aan de line items
                foreach ($eventIds as $eventId) {
                    $event = $this->getEventDetails($eventId);
                    if ($event !== null) {
                        $name = '';
                        $price = 0;
                        if ($event['type'] === 'restaurant') {
                            $adults = htmlspecialchars($_POST[$event['eventId'] . 'AdultsInput']);
                            $children = htmlspecialchars($_POST[$event['eventId'] . 'ChildrenInput']);
                            $name = $event['name'];
                            $price = $adults * 10 + $children * 10;
                            $this->personalProgramService->changeRestaurantQuantity($event['restaurantEventId'], $adults, $children);
                        } elseif ($event['type'] === 'history') {
                            $participants = htmlspecialchars($_POST[$event['eventId'] . 'QuantityInput']);
                            $name = 'Tour Haarlem';
                            $price = $event['price'] * $participants - floor($participants / 4) * 10;
                            $this->personalProgramService->changeHistoryQuantity($event['historyEventId'], $participants);
                        } elseif ($event['type'] === 'artist') {
                            $tickets = htmlspecialchars($_POST[$event['eventId'] . 'QuantityInput']);
                            $name = 'Jazz Festival with: ' . $event['name'];
                            $price = $event['price'] * $tickets;
                            $this->personalProgramService->changeArtistQuantity($event['artistEventId'], $tickets, $_SESSION['user_id']);
                        }

                        // Voeg een line item toe voor elk evenement
                        $lineItems[] = [
                            "quantity" => 1,
                            "price_data" => [
                                "currency" => "eur", // Euro
                                "unit_amount" =>  $price * 100, // Prijs in centen
                                "product_data" => [
                                    "name" => $name, 
                                ]
                            ],
                        ];
                    }
                }

                // DUHA-NOTE
                require_once __DIR__ . '/../vendor/autoload.php';

                $configPath = __DIR__ . '/../config/config.cfg';
                $config = parse_ini_file($configPath, true);

                \Stripe\Stripe::setApiKey($config['stripe']['stripe_secret_key']);


                // Maak de checkout-sessie met de juiste line items
                $checkout_session = \Stripe\Checkout\Session::create([
                    "mode" => "payment",
                    "success_url" => "http://localhost/paymentsuccess",
                    "cancel_url" => "http://localhost/personalprogram",
                    "line_items" => $lineItems, 
                    "metadata" => [
                        "eventIds" => json_encode($eventIds),
                    ],
                ]);

                $this->paymentService->createPayment($checkout_session->id, $checkout_session->amount_total / 100);
                
                http_response_code(303);
                header("Location: " . $checkout_session->url);
                exit; 
                
            } else {
                $this->returnError('No events selected');
            }
        }
    }

    public function removeEventId(): void
    {
        if (isset($_GET['removeEventId'])) {
            $eventId = htmlspecialchars($_GET['removeEventId']);
            $eventType = htmlspecialchars($_GET['eventType']);
            $subEventId = htmlspecialchars($_GET['subEventId']);
            $this->personalProgramService->removeEvent($eventId, $eventType, $subEventId);
        }
        header('Location: /personalprogram');
    }

    private function returnError($errorMessage): void
    {
        $this->flashHelper->setFlashMessage('error', $errorMessage);
        header('Location: /personalprogram');
        exit;
    }

    private function getEventDetails($eventId)
    {
        $event = null;
        $restaurantEvent = $this->personalProgramService->getRestaurantEventById($eventId);
        if ($restaurantEvent) {
            $event = $restaurantEvent;
            $event['type'] = 'restaurant';
        } else {
            $historyEvent = $this->personalProgramService->getHistoryEventById($eventId);
            if ($historyEvent) {
                $event = $historyEvent;
                $event['type'] = 'history';
            } else {
                $artistEvent = $this->personalProgramService->getArtistEventById($eventId);
                if ($artistEvent) {
                    $event = $artistEvent;
                    $event['type'] = 'artist';
                }
            }
        }
        return $event;
    }

    private function getEventsWithPaymentStatus($events)
    {
        $eventStatus = [];
        foreach ($events as $event) {
            if ($event['historyEventId'] !== null) {
                $historyEvent = $this->personalProgramService->getHistoryEventById($event['eventId']);
                $eventStatus[$event['eventId']] = $this->paymentService->getPaymentStatusByEventId($historyEvent['eventId']);
            } elseif ($event['restaurantEventId'] !== null) {
                $restaurantEvent = $this->personalProgramService->getRestaurantEventById($event['eventId']); // Correctie hier
                $eventStatus[$event['eventId']] = $this->paymentService->getPaymentStatusByEventId($restaurantEvent['eventId']);
            } elseif ($event['artistEventId'] !== null) {
                $artistEvent = $this->personalProgramService->getArtistEventById($event['eventId']);
                $eventStatus[$event['eventId']] = $this->paymentService->getPaymentStatusByEventId($artistEvent['eventId']);
            }
        }

        return $eventStatus;
    }

}
