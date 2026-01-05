<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use PDO;

class AuthModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function isUserExists($email)
    {
        $stmt = $this->pdo->prepare(query: 'SELECT userEmail FROM user WHERE userEmail = :userEmail');
        $stmt->execute([':userEmail' => $email]);
        return $stmt->fetch();
    }

    public function createNewUserQuery($name, $email, $password, $buisness = null)
    {
        if ($buisness === null) {
            $stmt = $this->pdo->prepare('INSERT INTO user(userName, userEmail, userPassword) VALUES (:userName, :userEmail, :userPassword)');
            $registered = $stmt->execute([':userName' => $name, ':userEmail' => $email, ':userPassword' => $password]);
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO user(userName, userEmail, userPassword, buisness) VALUES (:userName, :userEmail, :userPassword, :buisness)');
            $registered = $stmt->execute([':userName' => $name, ':userEmail' => $email, ':userPassword' => $password, ':buisness' => $buisness]);
        }
        return $registered;
    }

    public function getUserFromDB($email)
    {
        $stmt = $this->pdo->prepare(query: 'SELECT  userName, userEmail, userPassword, buisness FROM user WHERE userEmail = :userEmail');
        $stmt->execute([':userEmail' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserIdQuery($email)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM user WHERE userEmail = :userEmail');
        $stmt->execute([':userEmail' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
