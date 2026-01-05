<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuthModel;

class AuthService
{
    private AuthModel $model;

    public function __construct()
    {
        $this->model = new AuthModel();
    }

    public function createNewUser($name, $email, $password, $buisness = null)
    {
        if (empty($name) || empty($email) || empty($password)) {
            return ['error' => 'All fields are required'];
        }
        if (strlen($name) < 4) {
            return ['error' => 'Name must have at least 4 characters long'];
        }
        if (strlen($password) < 6) {
            return ['error' => 'Password must have at least 6 characters long'];
        }
        if ($this->model->isUserExists($email)) {
            return ['error' => 'User is already exists'];
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        if (!$this->model->createNewUserQuery($name, $email, $hashPassword, $buisness)) {
            return ['error' => 'User cannot be registered'];
        }
        return ['success' => true];
    }


    public function loginUser($email, $password)
    {
        if (empty($email) || empty($password)) {
            return ['error' => 'All fields are required'];
        }

        $getUserEmail = $this->model->getUserFromDB($email);
        if (!$getUserEmail) {
            return ['error' => 'User email is not exists'];
        }

        $hashedPassword = $getUserEmail['userPassword'];
        if (!password_verify($password, $hashedPassword)) {
            return ['error' => 'Invalid credentials'];
        }
        return $getUserEmail;
    }

    public function logoutUser()
    {
        session_start();
        $_SESSION = [];
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header('Location: /signin');
        exit();
    }


    public function getUserEmailFromEmail($email)
    {
        $userId = $this->model->getUserIdQuery($email);
        if (!$userId) {
            return ['error' => 'User email not found'];
        }
        return $userId['id'] ?? null;
    }
}
