<?php

namespace App\Controllers;

use App\Services\UserService;

class HomeController extends Controller{
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function index() : void {
        require_once __DIR__ . '/../views/home/index.php';
    }
}
