<?php

namespace App\Controllers;

use App\Helpers\RegexHelper;
use App\Services\MailerService;
use App\Services\UserService;
use App\Helpers\FlashHelper;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class ProfileController extends Controller
{
    private UserService $userService;
    private FlashHelper $flashHelper;
    private RegexHelper $regexHelper;
    private MailerService $mailerService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->flashHelper = new FlashHelper();
        $this->regexHelper = new RegexHelper();
        $this->mailerService = new MailerService();
    }


    public function index(): void
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            $user = $this->userService->getUserById($userId);

            if ($user) {
                require_once __DIR__ . '/../views/users/profile.php';
            } else {
                $this->flashHelper->setFlashMessage('error', 'User not found.');
                header('Location: /login');
            }
        } else {
            header('Location: /login');
            exit;
        }
    }

    public function updateProfile(): void
    {
        $userId = $_SESSION['user_id'];
        $username = isset($_POST['username']) ? $this->sanitizeString($_POST['username']) : '';
        $firstName = isset($_POST['firstName']) ? $this->sanitizeString($_POST['firstName']) : '';
        $lastName = isset($_POST['lastName']) ? $this->sanitizeString($_POST['lastName']) : '';
        $email = isset($_POST['email']) ? $this->sanitizeString($_POST['email']) : '';
        $currentPassword = isset($_POST['currentPassword']) ? $this->sanitizeString($_POST['currentPassword']) : '';
        $phoneNumber = isset($_POST['phoneNumber']) ? $this->sanitizeString($_POST['phoneNumber']) : '';
        $postalCode = isset($_POST['postalCode']) ? $this->sanitizeString($_POST['postalCode']) : '';
        $address = isset($_POST['address']) ? $this->sanitizeString($_POST['address']) : '';
        $houseNumber = isset($_POST['houseNumber']) ? $this->sanitizeString($_POST['houseNumber']) : '';

        $error = '';

        switch (true) {
            case empty($currentPassword):
                $error = "Current password is required.";
                break;
            case $this->userService->findByUsername($username) === true:
                $error = "Username already exists.";
                break;
            case !$this->regexHelper->isValidDutchPhoneNumber($phoneNumber):
                $error = "Invalid Dutch phone number.";
                break;
            case !$this->regexHelper->isValidDutchPostalCode($postalCode):
                $error = "Invalid Dutch postal code.";
                break;
            default:
                break;
        }

        if (!empty($error)) {
            $this->showProfileWithError($error);
        }

        try {
            $result = $this->userService->updateProfile($userId, $username, $firstName, $lastName, $email, $currentPassword, $phoneNumber, $postalCode, $address, $houseNumber);

            if (!$result) {
                $this->showProfileWithError("Wrong password");
            }

            $this->mailerService->sendEmail($email, "Profile Update", "Your profile has been updated. If this was not you, reset your password.");
            $this->showProfileWithSucces("Profile updated successfully.");
        } catch (Exception $e) {
            $this->showProfileWithError($e->getMessage());
        }
    }

    #[NoReturn] private function showProfileWithError($errorMessage): void
    {
        $this->flashHelper->setFlashMessage('error', $errorMessage);
        $this->redirectToProfile();
    }

    #[NoReturn] private function redirectToProfile(): void
    {
        header('Location: /profile');
        exit;
    }

    #[NoReturn] private function showProfileWithSucces($message): void
    {
        $this->flashHelper->setFlashMessage('success', $message);
        $this->redirectToProfile();
    }

    public function changePassword(): void
    {
        $userId = $_SESSION['user_id'];
        $email = isset($_POST['email']) ? $this->sanitizeString($_POST['email']) : '';
        $currentPassword = isset($_POST['currentPassword']) ? $this->sanitizeString($_POST['currentPassword']) : '';
        $newPassword = isset($_POST['newPassword']) ? $this->sanitizeString($_POST['newPassword']) : '';
        $newPasswordReenter = isset($_POST['newPasswordReenter']) ? $this->sanitizeString($_POST['newPasswordReenter']) : '';


        if (empty($currentPassword) || empty($newPassword) || empty($newPasswordReenter)) {
            $this->showProfileWithError("All password fields are required in the 'change password' section.");
        }

        if ($newPassword !== $newPasswordReenter) {
            $this->showProfileWithError("New passwords do not match.");
        }

        try {
            $result = $this->userService->changePassword($userId, $currentPassword, $newPassword);

            if (!$result) {
                $this->showProfileWithError("Incorrect current password or password update failed.");
            }

            $this->mailerService->sendEmail($email, "Password Change", "Your password has been changed. If this was not you, reset your password.");

            $this->showProfileWithSucces("Password changed successfully.");

        } catch (Exception $e) {
            $this->showProfileWithError($e->getMessage());
        }
    }
}
