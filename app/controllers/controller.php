<?php

namespace App\Controllers;

use JetBrains\PhpStorm\NoReturn;

class Controller
{
    protected function sanitizeString($string): string
    {
        return htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8');
    }
    protected function sanitizeInt($int): int
    {
        return (int) $int;
    }
    protected function sanitizeUrl($queryString): string
    {
        return preg_replace('/[^a-zA-Z0-9-_]/', '', trim($queryString));
    }

    protected function sanitizeHtml(string $htmlContent): string
    {
        $allowedTags = '<div><a><h1><h2><h3><h4><h5><h6><ul><ol><li><strong><em><br><span><b><u>';
        return strip_tags($htmlContent, $allowedTags);
    }
}
