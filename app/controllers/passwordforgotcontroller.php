<?php

namespace App\Controllers;

use App\Services\PasswordResetService;
use App\Services\MailerService;
use App\Helpers\FlashHelper;
use JetBrains\PhpStorm\NoReturn;

class PasswordForgotController extends Controller
{
    private PasswordResetService $passwordResetService;
    private MailerService $mailerService;
    private FlashHelper $flashHelper;
    public function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
        $this->mailerService = new MailerService();
        $this->flashHelper = new FlashHelper();
    }

    public function index(): void
    {
        require_once __DIR__ . '/../views/users/forgotpassword.php';
    }

    #[NoReturn] public function forgotPassword(): void
    {
        $email = isset($_POST['email']) ? $this->sanitizeString($_POST['email']) : '';
        $token = $this->passwordResetService->generateToken();

        if ($this->passwordResetService->requestPasswordReset($email, $token)) {

            $resetLink = "http://localhost/passwordreset?token=$token";
            $message = "Click <a href=\"$resetLink\">here</a> to reset your password.";

            $this->mailerService->sendEmail($email, "Password Reset",$message);

            $this->flashHelper->setFlashMessage('success', 'Please check your email to reset your password.');
            header('Location: /login');
        } else {
            $this->flashHelper->setFlashMessage('error', 'Failed to process your request.');
            header('Location: /passwordforgot');
        }
        exit();
    }
}
