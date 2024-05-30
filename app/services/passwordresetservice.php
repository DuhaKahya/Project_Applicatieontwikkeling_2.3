<?php

namespace App\Services;

use App\Repositories\PasswordResetRepository;

class PasswordResetService
{
    private PasswordResetRepository $passwordResetRepository;


    public function __construct()
    {
        $this->passwordResetRepository = new PasswordResetRepository();
    }

    public function requestPasswordReset($email, $token): bool
    {
        $hashedToken = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
        return $this->passwordResetRepository->createPasswordResetEntry($email, $hashedToken, $expiry);
    }

    public function resetPassword($token, $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashedToken = hash("sha256", $token);
        return $this->passwordResetRepository->updatePassword($hashedToken, $hashedPassword);
    }

    public function removeToken($token): void
    {
        $hashedToken = hash("sha256", $token);
        $this->passwordResetRepository->deleteToken($hashedToken);
    }

    public function isTokenValid($token)
    {
        $hashedToken = hash("sha256", $token);
        return $this->passwordResetRepository->verifyToken($hashedToken);
    }

    public function generateToken(): string
    {
        return bin2hex(random_bytes(16));
    }

}
