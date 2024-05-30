<?php

namespace App\Controllers;

use App\Services\ArtistService;

class JazzController extends Controller
{
    private ArtistService $artistService;

    public function __construct()
    {
        $this->artistService = new ArtistService();
    }
    public function index(): void
    {
        $artists = $this->artistService->getAllArtists();
        $events = $this->artistService->getAllEvents();

        require_once __DIR__ . '/../views/jazz/jazz.php';
    }
}
