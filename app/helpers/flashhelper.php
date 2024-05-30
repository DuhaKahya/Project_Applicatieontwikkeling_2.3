<?php

namespace App\Helpers;

class FlashHelper
{
    public function setFlashMessage($type, $message): void
    {
        $_SESSION['flash_messages'][$type] = $message;
    }

    public function displayFlashMessages(): void
    {
        if (isset($_SESSION['flash_messages'])) {
            foreach ($_SESSION['flash_messages'] as $type => $message) {
                $class = ($type == 'success') ? 'alert-success' : 'alert-danger';
                echo "<div class='alert {$class}'>{$message}</div>";
            }
            unset($_SESSION['flash_messages']);
        }
    }

    public function hasFlashMessages(): bool
    {
        return !empty($_SESSION['flash_messages']);
    }
}
