<?php

namespace App\Controllers;

class PaymentSuccessController extends Controller
{
    public function index(): void
    {
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit(); 
        }
        require_once __DIR__ . '/../views/payment/paymentsuccess.php';
    }
}