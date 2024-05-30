<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Helpers\FlashHelper;
use App\Helpers\RegexHelper;
use JetBrains\PhpStorm\NoReturn;

class RegisterController extends Controller
{
    private UserService $userService;
    private FlashHelper $flashHelper;
    private RegexHelper $regexHelper;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->flashHelper = new FlashHelper();
        $this->regexHelper = new RegexHelper();
    }

    public function index(): void
    {
        require_once __DIR__ . '/../views/users/register.php';
    }

    #[NoReturn] public function registerUser(): void
    {
        if (!$this->verifyRecaptcha($_POST['g-recaptcha-response'])) {
            $this->redirectToRegistrationWithError("reCAPTCHA verification failed. Please try again.");
        }

        $this->ensureIsPostRequest();

        $username = isset($_POST['username']) ? $this->sanitizeString($_POST['username']) : '';
        $firstName = isset($_POST['firstname']) ? $this->sanitizeString($_POST['firstname']) : '';
        $lastName = isset($_POST['lastname']) ? $this->sanitizeString($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? $this->sanitizeString($_POST['email']) : '';
        $password = isset($_POST['password']) ? $this->sanitizeString($_POST['password']) : '';
        $passwordReenter = isset($_POST['password-reenter']) ? $this->sanitizeString($_POST['password-reenter']) : '';
        $phoneNumber = isset($_POST['phoneNumber']) ? $this->sanitizeString($_POST['phoneNumber']) : '';
        $postalCode = isset($_POST['postalCode']) ? $this->sanitizeString($_POST['postalCode']) : '';
        $address = isset($_POST['address']) ? $this->sanitizeString($_POST['address']) : '';
        $houseNumber = isset($_POST['houseNumber']) ? $this->sanitizeString($_POST['houseNumber']) : '';

        if (!$username || !$firstName || !$lastName || !$email || !$password || !$passwordReenter || !$phoneNumber || !$postalCode || !$address || !$houseNumber) {
            $this->redirectToRegistrationWithError("All fields are required.");
        } elseif (!$this->regexHelper->isValidDutchPostalCode($postalCode)) {
            $this->redirectToRegistrationWithError("Invalid Dutch postal code.");
        } elseif (!$this->regexHelper->isValidDutchPhoneNumber($phoneNumber)) {
            $this->redirectToRegistrationWithError("Invalid Dutch phone number.");
        } elseif ($password !== $passwordReenter) {
            $this->redirectToRegistrationWithError("Passwords do not match.");
        }

        $roleId = 1;
        $result = $this->userService->register($username, $firstName, $lastName, $email, $password, $roleId, $phoneNumber, $postalCode, $address, $houseNumber);

        if (!$result) {
            $this->redirectToRegistrationWithError("Username already taken.");
        }

        $this->flashHelper->setFlashMessage('success', 'Account registerd successfully. Please login.');
        $this->redirectToLogin();
    }

    private function verifyRecaptcha($recaptchaResponse)
    {
        $config = $this->checkConfig();

        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$config['recaptcha']['secret_key']}&response={$recaptchaResponse}");
        $responseData = json_decode($response);
        return $responseData->success;
    }

    #[NoReturn] private function redirectToRegistrationWithError($errorMessage): void
    {
        $this->flashHelper->setFlashMessage('error', $errorMessage);
        $this->redirectToRegistration();
    }

    private function ensureIsPostRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToRegistration();
        }
    }

    #[NoReturn] private function redirectToRegistration(): void
    {
        header('Location: /register');
        exit;
    }

    #[NoReturn] private function redirectToLogin(): void
    {
        header('Location: /login');
        exit;
    }

    public function checkConfig()
    {
        $configPath = __DIR__ . '/../config/config.cfg';
        if (file_exists($configPath)) {
            $config = parse_ini_file($configPath, true);
        } else {
            die("Configuration file not found.");
        }
        return $config;
    }
}
