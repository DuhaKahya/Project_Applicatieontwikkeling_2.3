<?php

namespace App\Models;

class Song
{
    public int $songId;
    public int $artistId;
    public string $name;
    public string $musicPath;
    public string $imageCover;

    public function getSongId(): int
    {
        return $this->songId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMusicPath(): string
    {
        return $this->musicPath;
    }

    public function getArtistId(): int
    {
        return $this->artistId;
    }
    public function getImageCover(): string
    {
        return $this->imageCover;
    }
}
