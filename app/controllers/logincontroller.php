<?php

namespace App\Controllers;

use App\Helpers\FlashHelper;
use App\Services\UserService;
use JetBrains\PhpStorm\NoReturn;

class LoginController extends Controller
{
    private UserService $userService;

    private FlashHelper $flashHelper;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->flashHelper = new FlashHelper();
    }

    public function index(): void
    {
        require_once __DIR__ . '/../views/users/login.php';
    }

    #[NoReturn] public function login(): void
    {
        $this->ensureIsPostRequest();

        $input = $this->fetchAndSanitizeLoginInput();

        if (!$input['username'] || !$input['password']) {
            $this->showLoginWithError("Username and password are required.");
        }

        $user = $this->userService->login($input['username'], $input['password']);

        if (!$user) {
            $this->showLoginWithError("Invalid login credentials.");
        }

        $this->setUserSessionAndRedirect($user);
    }

    private function fetchAndSanitizeLoginInput(): array
    {
        $username = isset($_POST['username']) ? $this->sanitizeString($_POST['username']) : '';
        $password = isset($_POST['password']) ? $this->sanitizeString($_POST['password']) : '';

        return [
            'username' => $username,
            'password' => $password
        ];
    }

    #[NoReturn] private function setUserSessionAndRedirect($user): void
    {
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role_name'] = $user->getname();
        header('Location: /');
        exit;
    }

    private function ensureIsPostRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToLogin();
        }
    }

    #[NoReturn] private function redirectToLogin(): void
    {
        header('Location: /login');
        exit;
    }

    #[NoReturn] private function showLoginWithError($errorMessage): void
    {
        $this->flashHelper->setFlashMessage('error', $errorMessage);
        $this->redirectToLogin();
    }

    #[NoReturn] public function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
