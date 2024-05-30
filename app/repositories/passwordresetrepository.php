<?php

namespace App\Repositories;

use Exception;

class PasswordResetRepository extends Repository
{
    const TOKEN = ':token';

    public function createPasswordResetEntry($email, $tokenHash, $expiry): bool
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE Users
                SET resetTokenHash = :tokenHash,
                    resetTokenExpiresAt = :expiry
                WHERE email = :email
            ");
            $stmt->bindParam(':tokenHash', $tokenHash);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->bindParam(':email', $email);
            return $stmt->execute();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function verifyToken($tokenHash)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT resetTokenExpiresAt
                FROM Users
                WHERE resetTokenHash = :token
            ");
            $stmt->bindParam(self::TOKEN, $tokenHash);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function updatePassword($hashedToken, $hashedPassword): bool
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE Users
                SET password = :password
                WHERE resetTokenHash = :token
            ");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(self::TOKEN, $hashedToken);
            return $stmt->execute();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function deleteToken($hashedtoken): void
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE Users
                SET resetTokenHash = NULL,
                    resetTokenExpiresAt = NULL
                WHERE resetTokenHash = :token
            ");
            $stmt->bindParam(self::TOKEN, $hashedtoken);
            $stmt->execute();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }
}
