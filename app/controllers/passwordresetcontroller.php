<?php

namespace App\Controllers;

use App\Helpers\RegexHelper;
use App\Services\PasswordResetService;
use App\Helpers\FlashHelper;

class PasswordResetController extends Controller
{
    private PasswordResetService $passwordResetService;
    private FlashHelper $flashHelper;
    private RegexHelper $regexHelper;

    public function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
        $this->flashHelper = new FlashHelper();
        $this->regexHelper = new RegexHelper();
    }

    public function index(): void
    {
        $token = $this->sanitizeUrl($_GET['token'] ?? null);
        if ($token && $this->passwordResetService->isTokenValid($token)) {
            require_once __DIR__ . '/../views/users/passwordreset.php';
        } else {
            header('Location: /passwordforgot');
            $this->flashHelper->setFlashMessage('error', 'Invalid token, try sending the email again.');
        }
    }

    public function resetPassword(): void
    {
        $token = $_POST['token'] ?? null;
        $password = isset($_POST['password']) ? $this->sanitizeString($_POST['password']) : '';
        $passwordReenter = isset($_POST['password-reenter']) ? $this->sanitizeString($_POST['password-reenter']) : '';

        if ($password !== $passwordReenter) {
            $this->flashHelper->setFlashMessage('error', 'Passwords do not match.');
            header('Location: /passwordreset?token=' . $token);
            return;
        }

        if ($token && $this->passwordResetService->resetPassword($token, $password)) {
            $this->passwordResetService->removeToken($token);
            $this->flashHelper->setFlashMessage('success', 'Password reset successful.');
            header('Location: /login');
            exit();
        } else {
            $this->flashHelper->setFlashMessage('error', 'Password reset failed or token is invalid.');
            header('Location: /passwordreset?token=' . $token);
        }
    }
}
