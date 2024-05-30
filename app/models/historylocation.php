<?php

namespace App\Models;

class HistoryLocation
{
    private int $historyLocationId;
    private string $name;
    private string $imagePath;
    private string $aboutImagePath;
    private string $historyImagePath;
    private string|null $about;
    private string|null $history;

    public function getId(): int
    {
        return $this->historyLocationId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        $array = explode('/', $this->imagePath);
        return '/images/historyLocations/' . end($array);
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getAboutImage(): string
    {
        $array = explode('/', $this->aboutImagePath);
        return '/images/historyLocations/' . end($array);
    }

    public function getAboutImagePath(): string
    {
        return $this->aboutImagePath;
    }

    public function getHistoryImage(): string
    {
        $array = explode('/', $this->historyImagePath);
        return '/images/historyLocations/' . end($array);
    }

    public function getHistoryImagePath(): string
    {
        return $this->historyImagePath;
    }

    public function getAbout(): string
    {
        if ($this->about == null) {
            return "No information available";
        }
        return $this->about;
    }

    public function getHistory(): string|null
    {
        return $this->history;
    }
}