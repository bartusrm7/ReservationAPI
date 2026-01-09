<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        $port = 3306;
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $err) {
            die('Database error: ' . $err->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function createUserTable()
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            userName VARCHAR(255) NOT NULL,
            userEmail VARCHAR(255) NOT NULL,
            userPassword VARCHAR(255) NOT NULL,
            buisness BOOLEAN DEFAULT NULL
        )');
    }

    public function createMeetingTable()
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS meeting (
            id INT AUTO_INCREMENT PRIMARY KEY,
            meetingName VARCHAR(255) NOT NULL,
            meetingPlace VARCHAR(255) NOT NULL,
            meetingDate TIMESTAMP NOT NULL,
            createdBy  VARCHAR(255) NOT NULL
        )');
    }

    public function createUserMeetingsTable()
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS userMeetings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            userId INT NOT NULL,
            meetingId INT NOT NULL,
            FOREIGN KEY (userId) REFERENCES user(id) ON DELETE CASCADE,
            FOREIGN KEY (meetingId) REFERENCES meeting(id) ON DELETE CASCADE
        )');
    }
}
