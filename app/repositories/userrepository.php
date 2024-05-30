<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use PDO;

class UserRepository extends Repository
{
    public function findByUsername($username): bool|User
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT Users.userId, Users.username, Users.email, Users.password, Users.firstName, Users.lastName, Roles.name
                FROM Users
                JOIN 
	                Roles ON Users.roleId = Roles.roleId
                WHERE Users.username = :username
            ");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetchObject(User::class);

            if (!$user) {
                return false;
            }
            return $user;
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function getNameById($userId)
    {
        $stmt = $this->connection->prepare("
            SELECT username
            FROM Users
            WHERE userId = :userId
        ");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    public function findByEmail($email): bool|User
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT Users.userId, Users.username, Users.email, Users.password, Users.firstName, Users.lastName, Roles.name
                FROM Users
                JOIN 
	                Roles ON Users.roleId = Roles.roleId
                WHERE Users.email = :email
            ");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchObject(User::class);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function create($username, $firstName, $lastName, $email, $hashedPassword, $roleId, $phoneNumber, $postalCode, $address, $houseNumber): bool
    {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO Users (username, email, password, roleId, firstName, lastName, phoneNumber, postalCode, address, houseNumber)
                VALUES (:username, :email, :password, :roleId, :firstName, :lastName, :phoneNumber, :postalCode, :address, :houseNumber)
            ");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':postalCode', $postalCode);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':houseNumber', $houseNumber);
            return $stmt->execute();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function findById($userId)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT userId, username, email, Roles.name, password, firstName, lastName, phoneNumber, postalCode, address, houseNumber
                FROM Users
                JOIN Roles ON Users.roleId = Roles.roleId
                WHERE UserId = :userId
            ");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchObject(User::class);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'User not found.');
            header('Location: /');
            exit();
        }
    }

    public function getAllUsers(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT userId, username, email, Roles.name, firstName, lastName, registrationDate
            FROM Users
            JOIN Roles ON Users.roleId = Roles.roleId
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function getAllRoles(): bool|array
    {
        $stmt = $this->connection->prepare("
            SELECT roleId, name
            FROM Roles
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateProfile($userId, $username, $firstName, $lastName, $email, $phoneNumber, $postalCode, $address, $houseNumber): bool
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE Users
                SET username = :username,
                    email = :email,
                    firstName = :firstName,
                    lastName = :lastName,
                    phoneNumber = :phoneNumber,
                    postalCode = :postalCode,
                    address = :address,
                    houseNumber = :houseNumber
                WHERE userId = :userId
            ");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':postalCode', $postalCode);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':houseNumber', $houseNumber);
            return $stmt->execute();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }

    public function editUser($userId, $username, $email, $role, $firstName, $lastName, $phoneNumber, $postalCode, $address, $houseNumber): bool
    {
        $stmt = $this->connection->prepare("
            UPDATE Users
            SET username = :username,
                email = :email,
                roleId = :role,
                firstName = :firstName,
                lastName = :lastName,
                phoneNumber = :phoneNumber,
                postalCode = :postalCode,
                address = :address,
                houseNumber = :houseNumber
            WHERE userId = :userId
        ");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':postalCode', $postalCode);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':houseNumber', $houseNumber);
        return $stmt->execute();
    }

    public function deleteUser($userId): bool
    {
        $stmt = $this->connection->prepare("
            DELETE FROM Users
            WHERE userId = :userId
        ");
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    public function updatePassword($userId, $hashedNewPassword): bool
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE Users
                SET password = :password
                WHERE userId = :userId
            ");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':password', $hashedNewPassword);
            return $stmt->execute();
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Something went wrong.');
            header('Location: /');
            exit();
        }
    }
}
