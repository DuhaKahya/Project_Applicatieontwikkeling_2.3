<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Helpers\FlashHelper;
use PHPMailer\PHPMailer\SMTP;

class MailerService
{
    private FlashHelper $flashHelper;

    public function __construct()
    {
        $this->flashHelper = new FlashHelper();
    }
    public function configureMailer(): PHPMailer
    {
        $config = $this->checkConfig();

        $mail = new PHPMailer(true);

        $mail->isSMTP();

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = $config['email']['email_address'];
        $mail->Password = $config['email']['email_password'];

        $mail->isHTML(true);

        return $mail;
    }

    public function sendEmail($recipientEmail, $subject, $message): bool
    {
        $mail = $this->configureMailer();

        try {
            $mail->setFrom("TheFestival2024@outlook.com");
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            header('Location: /');
            exit();
        }
        $mail->addAddress($recipientEmail);
        $mail->Subject = $subject;
        $mail->Body = $message;

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            header('Location: /');
            exit();
        }
    }

    public function sendEmailWithAttachments($recipientEmail, $subject, $message, array $attachments): bool
    {
        $mail = $this->configureMailer();

        $mail->setFrom("TheFestival2024@outlook.com");
        $mail->addAddress($recipientEmail);
        $mail->Subject = $subject;
        $mail->Body = $message;
        foreach ($attachments as $attachment) {
            $mail->addStringAttachment($attachment, "attachment.pdf");
        }

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
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
