<?php

namespace App\Models;

class Artist
{
    public int $artistId;
    public string $name;
    public string $whoIs;
    public string $careerSummary;
    public string $importantTracks;
    public string $imageProfile;
    public string $imageCareerHighlights;
    public string $imageImportantTracks;
    public string $slug;
    public string $imageIcon;
    public string $artistEventLocation;
    public array $musicStyleNames = []; // Declare as an array
    public array $events = [];

    public function getArtistId(): int
    {
        return $this->artistId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWhoIs(): string
    {
        return $this->whoIs;
    }

    public function getCareerSummary(): string
    {
        return $this->careerSummary;
    }

    public function getImportantTracks(): string
    {
        return $this->importantTracks;
    }

    public function getImageProfile(): string
    {
        return $this->imageProfile;
    }

    public function getImageCareerHighlights(): string
    {
        return $this->imageCareerHighlights;
    }

    public function getImageImportantTracks(): string
    {
        return $this->imageImportantTracks;
    }

    public function getMusicStyleName(): string
    {
        return $this->musicStyleName;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getImageIcon(): string
    {
        return $this->imageIcon;
    }

    public function addEvent(array $eventData): void
    {
        $this->events[] = $eventData;
    }
    public function addMusicStyleName(string $styleName): void {
        $this->musicStyleNames[] = $styleName;
    }
}
