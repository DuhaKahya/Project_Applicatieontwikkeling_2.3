<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Services\HistoryService;
use App\Services\YummyService;
use App\Services\ReservationService;
use App\Services\RestaurantDetailPageService;
use App\Services\OrderService;

class DashBoardController extends Controller {

    private UserService $userService;
    private HistoryService $historyService;
    private YummyService $yummyService;
    private ReservationService $reservationService;
    private RestaurantDetailPageService $restaurantDetailPageService;
    private OrderService $orderService;
    

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role_name'] !== 'Admin') {
            header('Location: /');
            exit();
        }
        $this->userService = new UserService();
        $this->historyService = new HistoryService();
        $this->yummyService = new YummyService();
        $this->reservationService = new ReservationService();
        $this->restaurantDetailPageService = new RestaurantDetailPageService();
        $this->orderService = new OrderService();
    }

    public function index(): void
    {
        require_once __DIR__.'/../views/dashboard/index.php';
    }

    // Users

    public function users(): void
    {
        $users = $this->userService->getAllUsers();
        require_once __DIR__.'/../views/dashboard/users.php';
    }

    public function users_create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $roles = $this->userService->getAllRoles();
            require_once __DIR__.'/../views/dashboard/users_create.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $roleId = htmlspecialchars($_POST['role']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $password = htmlspecialchars($_POST['password']);
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
            $postalCode = htmlspecialchars($_POST['postalCode']);
            $address = htmlspecialchars($_POST['address']);
            $houseNumber = htmlspecialchars($_POST['houseNumber']);

            $errorMessage = $this->checkInputs($username, $email, '', '');
            if ($errorMessage !== '') {
                $_SESSION['errorMessage'] = $errorMessage;
                header('Location: /dashboard/users_create');
                exit();
            }
            else {
                $this->userService->register($username, $firstname, $lastname, $email, $password, $roleId, $phoneNumber, $postalCode, $address, $houseNumber);
                header('Location: /dashboard/users');
            }
        }
    }

    public function users_edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = htmlspecialchars($_GET['id']);
            $editedUser = $this->userService->getUserById($id);
            $roles = $this->userService->getAllRoles();
            require_once __DIR__.'/../views/dashboard/users_edit.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = htmlspecialchars($_POST['id']);
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $role = htmlspecialchars($_POST['role']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
            $postalCode = htmlspecialchars($_POST['postalCode']);
            $address = htmlspecialchars($_POST['address']);
            $houseNumber = htmlspecialchars($_POST['houseNumber']);

            $editedUser = $this->userService->getUserById($id);
            $errorMessage = $this->checkInputs($username, $email, $editedUser->username, $editedUser->email);
            if ($errorMessage !== '') {
                $_SESSION['errorMessage'] = $errorMessage;
                header('Location: /dashboard/users_edit?id=' . $id);
                exit();
            }
            else {
                $this->userService->editUser($id, $username, $email, $role, $firstname, $lastname, $phoneNumber, $postalCode, $address, $houseNumber);
                header('Location: /dashboard/users');
            }
        }
    }

    private function checkInputs($username, $email, $oldUsername, $oldEmail): string
    {
        if ($this->usernameExists($username) && $username !== $oldUsername) {
            return 'Username already exists';
        }
        if ($this->emailExists($email) && $email !== $oldEmail) {
            return 'Email already exists';
        }
        return '';
    }

    private function usernameExists($username): bool
    {
        return $this->userService->findByUsername($username) !== false;
    }

    private function emailExists($email): bool
    {
        return $this->userService->findByEmail($email) !== false;
    }

    public function users_delete(): void
    {
        $id = htmlspecialchars($_GET['id']);
        $this->userService->deleteUser($id);
        header('Location: /dashboard/users');
    }


    // History

    public function historyLocations(): void
    {
        $historyLocations = $this->historyService->getAllHistoryLocations();
        require_once __DIR__.'/../views/dashboard/historyLocations.php';
    }

    public function historyLocations_create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__.'/../views/dashboard/historyLocations_create.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $locationName = htmlspecialchars($_POST['name']);
            $imagePath = $this->processUploadedFile($_FILES['file']);
            $aboutImagePath = $this->processUploadedFile($_FILES['aboutImage']);
            $historyImagePath = $this->processUploadedFile($_FILES['historyImage']);
            $about = htmlspecialchars($_POST['aboutTextarea']);
            $history = htmlspecialchars($_POST['historyTextarea']);
            if (isset($_SESSION['errorMessage'])) {
                header('Location: /dashboard/historyLocations_create');
                exit();
            }
            $this->historyService->createHistoryLocation($locationName, $imagePath, $aboutImagePath, $historyImagePath, $about, $history);
            header('Location: /dashboard/historyLocations');
        }
    }

    public function historyLocations_edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = htmlspecialchars($_GET['id']);
            $editedHistoryLocation = $this->historyService->getHistoryLocationById($id);
            require_once __DIR__.'/../views/dashboard/historyLocations_edit.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = htmlspecialchars($_POST['id']);
            $editedHistoryLocation = $this->historyService->getHistoryLocationById($id);
            $locationName = htmlspecialchars($_POST['name']);
            $about = htmlspecialchars($_POST['aboutTextarea']);
            $history = htmlspecialchars($_POST['historyTextarea']);
            if (!empty($_FILES['file']['name'])) {
                $file = $_FILES['file'];
                $imagePath = $this->processUploadedFile($file);
                if (isset($_SESSION['errorMessage'])) {
                    header('Location: /dashboard/historyLocations_edit?id=' . $id);
                    exit();
                }
                $this->deleteFile($editedHistoryLocation->getImagePath());
            }
            else {
                $imagePath = $editedHistoryLocation->getImagePath();
            }
            if (!empty($_FILES['aboutImage']['name'])) {
                $file = $_FILES['aboutImage'];
                $aboutImagePath = $this->processUploadedFile($file);
                if (isset($_SESSION['errorMessage'])) {
                    header('Location: /dashboard/historyLocations_edit?id=' . $id);
                    exit();
                }
                $this->deleteFile($editedHistoryLocation->getAboutImagePath());
            }
            else {
                $aboutImagePath = $editedHistoryLocation->getAboutImagePath();
            }
            if (!empty($_FILES['historyImage']['name'])) {
                $file = $_FILES['historyImage'];
                $historyImagePath = $this->processUploadedFile($file);
                if (isset($_SESSION['errorMessage'])) {
                    header('Location: /dashboard/historyLocations_edit?id=' . $id);
                    exit();
                }
                $this->deleteFile($editedHistoryLocation->getHistoryImagePath());
            }
            else {
                $historyImagePath = $editedHistoryLocation->getHistoryImagePath();
            }
            $this->historyService->updateHistoryLocation($id, $locationName, $imagePath, $aboutImagePath, $historyImagePath, $about, $history);
            header('Location: /dashboard/historyLocations');
        }
    }

    public function historyLocations_delete(): void
    {
        $id = htmlspecialchars($_GET['id']);
        $historyLocation = $this->historyService->getHistoryLocationById($id);
        $this->deleteFile($historyLocation->getImagePath());
        $this->deleteFile($historyLocation->getAboutImagePath());
        $this->deleteFile($historyLocation->getHistoryImagePath());
        $this->historyService->deleteHistoryLocation($id);
        header('Location: /dashboard/historyLocations');
    }

    public function historyTours(): void
    {
        $historyTours = $this->historyService->getAllHistoryTours();
        require_once __DIR__.'/../views/dashboard/historyTours.php';
    }

    public function historyTours_create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $languages = $this->historyService->getAllLanguages();
            require_once __DIR__.'/../views/dashboard/historyTours_create.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $languageId = htmlspecialchars($_POST['language']);
            $startDateTime = htmlspecialchars($_POST['startDateTime']);
            $maxParticipants = htmlspecialchars($_POST['maxParticipants']);
            $price = htmlspecialchars($_POST['price']);
            $tourGuide = htmlspecialchars($_POST['tourGuide']);
            $this->historyService->createHistoryTour($languageId, $startDateTime, $maxParticipants, $price, $tourGuide);
            header('Location: /dashboard/historyTours');
        }
    }

    public function historyTours_edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = htmlspecialchars($_GET['id']);
            $editedHistoryTour = $this->historyService->getHistoryTourById($id);
            $languages = $this->historyService->getAllLanguages();
            require_once __DIR__.'/../views/dashboard/historyTours_edit.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = htmlspecialchars($_POST['id']);
            $languageId = htmlspecialchars($_POST['language']);
            $startDateTime = htmlspecialchars($_POST['startDateTime']);
            $maxParticipants = htmlspecialchars($_POST['maxParticipants']);
            $price = htmlspecialchars($_POST['price']);
            $tourGuide = htmlspecialchars($_POST['tourGuide']);
            $this->historyService->updateHistoryTour($id, $languageId, $startDateTime, $maxParticipants, $price, $tourGuide);
            header('Location: /dashboard/historyTours');
        }
    }

    public function historyTours_delete(): void
    {
        $id = htmlspecialchars($_GET['id']);
        $this->historyService->deleteHistoryTour($id);
        header('Location: /dashboard/historyTours');
    }
    // Files History
    
    private function processUploadedFile($file): string
    {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileTmpName = $file['tmp_name'];
        $explodedFile = explode('.', $fileName);
        $fileExtension = strtolower(end($explodedFile));

        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedExtensions)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $newFileName = uniqid('', true) . '.' . $fileExtension;
                    $fileDestination = __DIR__ . '/../public/images/historyLocations/' . $newFileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return $fileDestination;
                }
                else {
                    $_SESSION['errorMessage'] = 'File is too big';
                }
            }
            else {
                $_SESSION['errorMessage'] = 'There was an error uploading the file';
            }
        }
        else {
            $_SESSION['errorMessage'] = 'Invalid file type';
        }
        return '';
    }

    private function deleteFile($destination): void
    {
        if (file_exists($destination)) {
            unlink($destination);
        }
    }

    // Restaurants

    public function restaurants(): void
    {
        $restaurants = $this->yummyService->getAllRestaurants();
        $specialities = $this->yummyService->getAllSpecialities();
        require_once __DIR__.'/../views/dashboard/restaurants.php';
    }

    public function restaurants_create(): void // moet nog fixen
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $restaurantDetailPages = $this->restaurantDetailPageService->getAllRestaurantDetailPages();
            $specialities = $this->yummyService->getAllSpecialities();

            require_once __DIR__.'/../views/dashboard/restaurants_create.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {            

             // Voeg het restaurant toe aan de database
            $specialityId = $_POST['speciality'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            $price = $_POST['price'];
            $places = $_POST['places'];
            $rating = $_POST['rating'];
            $number = $_POST['number'];
            $email = $_POST['email'];
            $titleDescription = $_POST['titleDescription'];
            $pageDescription = $_POST['pageDescription'];
            $reservationText = $_POST['reservationText'];

            // Valideer en verwerk geüploade afbeeldingen
            $image = $this->processUploadedFileRestaurant($_FILES['image']);

            $imageDetail1 = "";
            $imageDetail2 = "";
            $imageDetail3 = "";
            $imageDetail4 = "";

            if (!empty($_FILES['image1']['name'])) {
                $imageDetail1 = $this->processUploadedFileRestaurant($_FILES['image1']);
            }

            if (!empty($_FILES['image2']['name'])) {
                $imageDetail2 = $this->processUploadedFileRestaurant($_FILES['image2']);
            }

            if (!empty($_FILES['image3']['name'])) {
                $imageDetail3 = $this->processUploadedFileRestaurant($_FILES['image3']);
            }

            if (!empty($_FILES['image4']['name'])) {
                $imageDetail4 = $this->processUploadedFileRestaurant($_FILES['image4']);
            }

            // Controleer of er fouten zijn opgetreden tijdens het uploaden van de afbeeldingen
            if (isset($_SESSION['errorMessage'])) {
                header('Location: /dashboard/restaurants_create');
                exit();
            }

            $this->yummyService->createRestaurant($specialityId, $name, $description, $image, $location, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText);
            
            header('Location: /dashboard/restaurants');
        }
    }


    public function restaurants_edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            
            $restaurantDetailPages = $this->restaurantDetailPageService->getAllRestaurantDetailPages();
            $editedRestaurant = $this->yummyService->getRestaurantById($id);
            $specialities = $this->yummyService->getAllSpecialities();
            require_once __DIR__.'/../views/dashboard/restaurants_edit.php';
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $id = $_POST['id'];
    
            $editedRestaurant = $this->yummyService->getRestaurantById($id);
            $editedDetailPage = $this->restaurantDetailPageService->getRestaurantDetailsByRestaurantId($id);
    
            $restaurantName = $_POST['name'];
            $specialityId = $_POST['speciality'];
            $description = $_POST['description'];
            $locationName = $_POST['location'];
            $price = $_POST['price'];
            $places = $_POST['places'];
            $rating = $_POST['rating'];
            $number = $_POST['number'];
            $email = $_POST['email'];
            $titleDescription = $_POST['titleDescription'];
            $pageDescription = $_POST['pageDescription'];
            $reservationText = $_POST['reservationText'];
    
            // Initialize $image with the existing image path
            $image = $editedRestaurant->getImage();
            $imageDetail1 = $editedDetailPage->getImageDetail1();
            $imageDetail2 = $editedDetailPage->getImageDetail2();
            $imageDetail3 = $editedDetailPage->getImageDetail3();
            $imageDetail4 = $editedDetailPage->getImageDetail4();
    
            // Handle uploaded images

            if (!empty($_FILES['image']['name'])) {
                $image = $this->processUploadedFileRestaurant($_FILES['image']);
            }
            
            if (!empty($_FILES['image1']['name'])) {
                $imageDetail1 = $this->processUploadedFileRestaurant($_FILES['image1']);
            }
    
            if (!empty($_FILES['image2']['name'])) {
                $imageDetail2 = $this->processUploadedFileRestaurant($_FILES['image2']);
            }
    
            if (!empty($_FILES['image3']['name'])) {
                $imageDetail3 = $this->processUploadedFileRestaurant($_FILES['image3']);
            }
    
            if (!empty($_FILES['image4']['name'])) {
                $imageDetail4 = $this->processUploadedFileRestaurant($_FILES['image4']);
            }
    
            // Update the restaurant and restaurant detail page with the new data
            $this->yummyService->updateRestaurant($id, $specialityId, $restaurantName, $description, $image, $locationName, $price, $places, $rating, $number, $email, $imageDetail1, $imageDetail2, $imageDetail3, $imageDetail4, $titleDescription, $pageDescription, $reservationText);
            header('Location: /dashboard/restaurants');
        }
    }

    public function restaurants_delete(): void
    {
        $id = $_GET['id'];
        $this->yummyService->deleteRestaurant($id);
        $this->restaurantDetailPageService->deleteRestaurantDetailPage($id);
        header('Location: /dashboard/restaurants');
    }

    // Files Restaurant

    private function processUploadedFileRestaurant($file): string
    {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileTmpName = $file['tmp_name'];
        $explodedFile = explode('.', $fileName);
        $fileExtension = strtolower(end($explodedFile));

        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedExtensions)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileDestination = __DIR__ . '/../public/images/yummy/' . $fileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return $fileName; // Gebruik de oorspronkelijke bestandsnaam
                } else {
                    $_SESSION['errorMessage'] = 'File is too big';
                }
            } else {
                $_SESSION['errorMessage'] = 'There was an error uploading the file';
            }
        } else {
            $_SESSION['errorMessage'] = 'Invalid file type';
        }
        return ''; // Geen nieuw bestand, lege string retourneren
    }



    // Restaurant Sessions
    
    public function restaurantsessions(): void
    {
        $sessions = $this->yummyService->getAllSessions();

        require_once __DIR__.'/../views/dashboard/restaurantsessions.php';
    }

    public function restaurantsessions_create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            
            require_once __DIR__.'/../views/dashboard/restaurantsession_create.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $startTime = $_POST['starttime'];
            $endTime = $_POST['endtime'];

            if (isset($_SESSION['errorMessage'])) {
                header('Location: /dashboard/restaurantsession_create');
                exit();
            }
            $this->yummyService->createSession($startTime, $endTime);
            header('Location: /dashboard/restaurantsessions');
        }
    }

    public function restaurantsessions_edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $id = $_GET['id'];

            $editedSession = $this->yummyService->getSessionById($id);

            require_once __DIR__.'/../views/dashboard/restaurantsession_edit.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $editedSession = $this->yummyService->getSessionById($id);
            $startTime = $_POST['starttime'];
            $endTime = $_POST['endtime'];
        
            $this->yummyService->updateSession($id, $startTime, $endTime);
            header('Location: /dashboard/restaurantsessions');
        }
    }


    public function restaurantsessions_delete(): void
    {
        $id = $_GET['id'];
        $this->yummyService->deleteSession($id);
        header('Location: /dashboard/restaurantsessions');
    }

    // Reservations
    
    public function reservations(): void
    {
        $reservations = $this->reservationService->getAllReservations();
        $restaurants = $this->yummyService->getAllRestaurants();
        $sessions = $this->yummyService->getAllSessions();
        $reservationDays = $this->reservationService->getAllDays();
        $users = $this->userService->getAllUsers();
        
        require_once __DIR__.'/../views/dashboard/reservations.php';
    }

    public function reservations_create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $restaurants = $this->yummyService->getAllRestaurants();
            $sessions = $this->yummyService->getAllSessions();
            $reservationDays = $this->reservationService->getAllDays();
            $users = $this->userService->getAllUsers();

            require_once __DIR__.'/../views/dashboard/reservations_create.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $_POST['userName'];
            $restaurantId = $_POST['restaurantId'];
            $sessionId = $_POST['sessionId'];
            $reservationDayId = $_POST['reservationDayId'];
            $specificRequest = $_POST['specificRequest'];
            $adults = $_POST['adults'];
            $children = $_POST['children'];


            if (isset($_SESSION['errorMessage'])) {
                header('Location: /dashboard/reservations_create');
                exit();
            }

            $availablePlaces = $this->yummyService->getAvailablePlaces($restaurantId, $sessionId, $reservationDayId);

            // Check of er genoeg plek is om de reservering aan te maken, anders maak een alert aan
            if ($availablePlaces < $adults + $children) {
                echo "<script>alert('Not enough places available (Places available: $availablePlaces). Please select another day or time.');</script>";
    
                // Redirect back to the add reservation page
                echo "<script>window.location.href = '/dashboard/reservations_create';</script>";
                exit();
                
            }


            $this->reservationService->createReservation($userId, $restaurantId, $sessionId, $reservationDayId, $specificRequest, $adults, $children);
            header('Location: /dashboard/reservations');
        }
    }

    public function reservations_edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $id = $_GET['id'];

            $editedReservation = $this->reservationService->getReservationById($id);

            $restaurants = $this->yummyService->getAllRestaurants();
            $sessions = $this->yummyService->getAllSessions();
            $reservationDays = $this->reservationService->getAllDays();
            $users = $this->userService->getAllUsers();

            require_once __DIR__.'/../views/dashboard/reservations_edit.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id']; // zorg ervoor dat je het juiste id ophaalt uit het formulier
            
            $editedReservation = $this->reservationService->getReservationById($id);

          

            $userId = $_POST['userName'];
            $restaurantId = $_POST['restaurantId'];
            $sessionId = $_POST['sessionId'];
            $reservationDay = $_POST['reservationDayId'];
            $specificRequest = $_POST['specificRequest'];
            $adults = $_POST['adults'];
            $children = $_POST['children'];
            $status = $_POST['status'];
        
            // Zorg ervoor dat je de juiste variabele doorgeeft
            $this->reservationService->updateReservation($id, $userId, $restaurantId, $sessionId, $reservationDay, $specificRequest, $adults, $children, $status);
            header('Location: /dashboard/reservations');
        }
    }


    public function reservations_delete(): void
    {
        $id = $_GET['id'];
        $this->reservationService->deleteReservation($id);
        header('Location: /dashboard/reservations');
    }

    public function orders(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['columns'])) {

            $selectedColumns = $_POST['columns'];

            $orders = $this->orderService->getAllOrders();

            
            $totalPrices = [];
            foreach ($orders as $order) {
                $totalPrices[$order->getPaymentId()] = $this->orderService->getTotalPriceByPaymentId($order->getPaymentId());
            }

            // Set headers for CSV file
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=orders.csv');

            // Open the output stream
            $output = fopen('php://output', 'w');

            // Write the header row to the CSV file
            fputcsv($output, $selectedColumns);

            // Iterate through each order and write selected data to the CSV file
            foreach ($orders as $order) {
                $rowData = [];
                foreach ($selectedColumns as $column) {
                    switch ($column) {
                        case 'orderId':
                            $rowData[] = $order->getOrderId();
                            break;
                        case 'paymentId':
                            $rowData[] = $order->getPaymentId();
                            break;
                        case 'date':
                            $rowData[] = $order->getDate();
                            break;
                        case 'totalPrice':
                            $totalPrice = $totalPrices[$order->getPaymentId()] ?? null;
                            $rowData[] = $totalPrice['totalPrice'];
                            break;
                    }
                }

                // Write row data to the CSV file
                fputcsv($output, $rowData);
            }

            // Close the output stream
            fclose($output);

            exit();

        } else {

            $orders = $this->orderService->getAllOrders();

            $totalPrices = [];
            foreach ($orders as $order) {
                $totalPrices[$order->getPaymentId()] = $this->orderService->getTotalPriceByPaymentId($order->getPaymentId());
            }

            require_once __DIR__.'/../views/dashboard/orders.php';
        }
    }



}