<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getNameById($userId)
    {
        return $this->userRepository->getNameById($userId);
    }

    public function findByEmail($email): bool|User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function login($username, $password): User|bool
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }

        return false;
    }

    public function findByUsername($username): bool|User
    {
        return $this->userRepository->findByUsername($username);
    }

    public function register($username, $firstName, $lastName, $email, $password, $roleId, $phoneNumber, $postalCode, $address, $houseNumber): bool
    {
        if ($this->userRepository->findByUsername($username) !== false) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->userRepository->create($username, $firstName, $lastName, $email, $hashedPassword, $roleId,  $phoneNumber, $postalCode, $address, $houseNumber);
    }

    public function getUserById($userId)
    {
        return $this->userRepository->findById($userId);
    }

    public function getAllUsers(): bool|array
    {
        return $this->userRepository->getAllUsers();
    }

    public function getAllRoles(): bool|array
    {
        return $this->userRepository->getAllRoles();
    }

    public function updateProfile($userId, $username, $firstName, $lastName, $email, $currentPassword, $phoneNumber, $postalCode, $address, $houseNumber): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!$user || !password_verify($currentPassword, $user->password)) {
            return false;
        }

        // Proceed with updating the profile if the password is correct
        return $this->userRepository->updateProfile($userId, $username, $firstName, $lastName, $email, $phoneNumber, $postalCode, $address, $houseNumber);
    }

    public function editUser($userId, $username, $email, $roleId, $firstName, $lastName, $phoneNumber, $postalCode, $address, $houseNumber): bool
    {
        return $this->userRepository->editUser($userId, $username, $email, $roleId, $firstName, $lastName, $phoneNumber, $postalCode, $address, $houseNumber);
    }

    public function deleteUser($userId): bool
    {
        return $this->userRepository->deleteUser($userId);
    }

    public function changePassword($userId, $currentPassword, $newPassword): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!$user || !password_verify($currentPassword, $user->password)) {
            return false;
        }

        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->userRepository->updatePassword($userId, $hashedNewPassword);
    }
}
