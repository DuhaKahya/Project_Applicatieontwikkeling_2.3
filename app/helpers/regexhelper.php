<?php

namespace App\Helpers;

class RegexHelper
{
    public function isValidDutchPostalCode($postalCode): bool|int
    {
        $pattern = '/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/';
        return preg_match($pattern, $postalCode);
    }

    public function isValidDutchPhoneNumber($phoneNumber): bool|int
    {
        $pattern = '/^(\+31|0)(6|7|8|9)[0-9]{8}$/';
        return preg_match($pattern, $phoneNumber);
    }

    public function isValidUrl($slug): bool|int
    {
        $pattern = '/^[a-z0-9-]+$/';
        return preg_match($pattern, $slug);
    }
}
