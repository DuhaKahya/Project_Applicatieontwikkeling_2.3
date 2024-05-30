<?php

namespace App\Controllers;

use App\Services\ArtistService;
use App\Helpers\RegexHelper;

class ArtistController extends Controller
{
    private ArtistService $artistService;
    private RegexHelper $regexHelper;

    public function __construct()
    {
        $this->artistService = new ArtistService();
        $this->regexHelper = new RegexHelper();
    }

    public function index(): void
    {
        $slug = $this->sanitizeUrl($_GET['artist'] ?? '');

        if (!$this->regexHelper->isValidUrl($slug)) {
            return;
        }

        $artist = $this->artistService->getArtistDetails($slug);
        $schedule = $this->artistService->getArtistSchedule($slug);
        $songs = $this->artistService->getArtistSongs($slug);

        require_once __DIR__ . '/../views/jazz/artist.php';
    }
}
