<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\AuthService;

class AuthController
{
    public AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'userPassword');
            $buisness = filter_has_var(INPUT_POST, 'buisnessAccount') ? 1 : null;

            $createUser = $this->service->createNewUser($name, $email, $password, $buisness);
            if (isset($createUser['error'])) {
                echo $createUser['error'];
                return;
            }
            header('Location: /signin');
        }
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'userPassword');

            $loginUser = $this->service->loginUser($email, $password);
            if (isset($loginUser['error'])) {
                echo $loginUser['error'];
                return;
            }

            session_set_cookie_params([
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            session_start();
            $_SESSION['userEmail'] = $email;

            $name = $loginUser['userName'];
            $_SESSION['userName'] = $name;

            $buisness = $loginUser['buisness'];
            if ($buisness) {
                $_SESSION['buisness'] = $buisness;
            }
            session_regenerate_id(true);
            header('Location: /dashboard');
            exit();
        }
    }

    public function logout()
    {
        return $this->service->logoutUser();
    }
}
