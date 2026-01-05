<?php

use App\Database\Database;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Database/Database.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$db->createUserTable();
$db->createMeetingTable();
$db->createUserMeetingsTable();
