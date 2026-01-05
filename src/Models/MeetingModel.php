<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use PDO;

class MeetingModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function createNewMeetingQuery($name, $place, $date, $email)
    {
        $stmt = $this->pdo->prepare('INSERT INTO meeting(meetingName, meetingPlace, meetingDate, createdBy) VALUES (:meetingName, :meetingPlace, :meetingDate, :userEmail)');
        $meeting = $stmt->execute([':meetingName' => $name, ':meetingPlace' => $place, ':meetingDate' => $date, ':userEmail' => $email]);
        return $meeting;
    }

    public function displayMeetings()
    {
        $stmt = $this->pdo->query('SELECT * FROM meeting');
        $meetings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $meetings;
    }

    public function editMeetingQuery($id, $name, $place, $date)
    {
        $stmt = $this->pdo->prepare('UPDATE meeting SET meetingName = :meetingName, meetingPlace = :meetingPlace, meetingDate = :meetingDate WHERE id = :id');
        $meeting = $stmt->execute([':id' => $id, ':meetingName' => $name, ':meetingPlace' => $place, ':meetingDate' => $date]);
        return $meeting;
    }

    public function getMeetingDataByIdQuery($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM meeting WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkIsMeetingsToUserExists($id, $meeting)
    {
        $stmt = $this->pdo->prepare('SELECT 1 FROM userMeetings WHERE userId = :userId AND meetingId = :meetingId');
        $stmt->execute([':userId' => $id, ':meetingId' => $meeting]);
        $exists = $stmt->fetch(PDO::FETCH_ASSOC);
        return $exists;
    }

    public function addMeetingToUserQuery($id, $meeting)
    {
        $stmt = $this->pdo->prepare('INSERT INTO userMeetings (userId, meetingId) VALUES (:userId, :meetingId)');
        $userMeeting = $stmt->execute([':userId' => $id, ':meetingId' => $meeting]);
        return $userMeeting;
    }

    public function getMeetingsForLoggedUserQuery($userId)
    {
        $stmt = $this->pdo->prepare('SELECT meetingId FROM userMeetings WHERE userId = :userId');
        $stmt->execute([':userId' => $userId]);
        $meetings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $meetings;
    }
}
