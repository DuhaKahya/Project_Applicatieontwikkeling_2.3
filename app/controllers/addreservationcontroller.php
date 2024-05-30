<?php

namespace App\Controllers;

use App\Services\YummyService;
use App\Services\ReservationService;

use App\Models\RestaurantEvent;

class AddReservationController extends Controller
{
    private YummyService $yummyService;
    private ReservationService $reservationService;

    public function __construct()
    {
        $this->yummyService = new YummyService();
        $this->reservationService = new ReservationService();
    }

    public function index(): void
    {
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $this->validateForm();
        } else {
            // If the form is not submitted, retrieve necessary data and render the form
            $restaurantSessions = $this->reservationService->getAllSessions();
            $reservationDays = $this->reservationService->getAllDays();

            require_once __DIR__ . '/../views/yummy/addreservation.php';
        }
    }



    private function validateForm(): bool
    {
         // Validate and sanitize the form data
         $day = htmlspecialchars($_POST['day']);
         $time = htmlspecialchars($_POST['time']);
         $adults = intval($_POST['adults']);
         $children = isset($_POST['children']) ? intval($_POST['children']) : 0;
         $requests = htmlspecialchars($_POST['requests']);

        // Retrieve restaurantId based on the restaurant name
        $restaurantName = htmlspecialchars($_GET['restaurant'] ?? '');
        $restaurantId = $this->yummyService->getIdByName($restaurantName);

        // Retrieve the restaurantsessionsId based on the selected time
        $timeArray = explode(' - ', $time);
        $startTime = $timeArray[0];
        $endTime = $timeArray[1];
        $restaurantsessionId = $this->reservationService->getIdByStartTimeAndEndTime($startTime, $endTime);

        // retrieve the reservationDayId based on the selected day
        $reservationDayId = $this->reservationService->getIdByDay($day);

        $availablePlaces = $this->yummyService->getAvailablePlaces($restaurantId, $restaurantsessionId, $reservationDayId);

        // Check of er genoeg plek is om de reservering aan te maken, anders maak een alert aan
        if ($availablePlaces < $adults + $children) {
            echo "<script>alert('Not enough places available (Places available: $availablePlaces). Please select another day or time.');</script>";

            // Redirect back to the add reservation page
            echo "<script>window.location.href = '/addreservation?restaurant=$restaurantName';</script>";
            exit();
            
        }

         // Create a new RestaurantEvent object with the form data
         $restaurantEvent = new RestaurantEvent();
         $restaurantEvent->setUserId($_SESSION['user_id']);
         $restaurantEvent->setRestaurantId($restaurantId);
         $restaurantEvent->setRestaurantSessionId($restaurantsessionId);
         $restaurantEvent->setReservationDayId($reservationDayId);
         $restaurantEvent->setSpecificRequest($requests);
         $restaurantEvent->setAdults($adults);
         $restaurantEvent->setChildren($children);

         // Insert the reservation into the database using the service
         $success = $this->reservationService->insertRestaurantEvent($restaurantEvent);

         if ($success) {

                // Redirect to the reservation overview page
                header("Location: /confirmreservation?restaurant=$restaurantName&day=$day&time=$time&adults=$adults&children=$children&requests=$requests");

             
             exit();
         } else {

             echo "Failed to insert reservation into the database.";
         }
    }
    

}
