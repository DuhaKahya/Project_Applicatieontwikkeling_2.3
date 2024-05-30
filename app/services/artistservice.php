<?php

namespace App\Services;

use App\repositories\ArtistRepository;

class ArtistService {
    private ArtistRepository $artistRepository;

    public function __construct() {
        $this->artistRepository = new ArtistRepository();
    }
    public function getArtistDetails($artist)
    {
        return $this->artistRepository->findArtistBySlug($artist);
    }
    public function getAllArtists(): bool|array
    {
        return $this->artistRepository->getAllArtists();
    }
    public function getArtistSchedule($slug): bool|array
    {
        return $this->artistRepository->findScheduleByArtistSlug($slug);
    }
    public function getArtistSongs($slug): bool|array
    {
        return $this->artistRepository->findSongsByArtistSlug($slug);
    }

    public function getAllEvents()
    {
        return $this->artistRepository->getAllEvents();
    }
}
