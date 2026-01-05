<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\AuthService;
use App\Services\MeetingService;

class MeetingController
{
    private AuthService $authService;
    private MeetingService $service;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->service = new MeetingService();
    }

    public function createMeeting()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = filter_input(INPUT_POST, 'meetingName', FILTER_SANITIZE_SPECIAL_CHARS);
            $place = filter_input(INPUT_POST, 'meetingPlace', FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_input(INPUT_POST, 'meetingDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            session_start();
            $email = $_SESSION['userEmail'];

            $createMeeting = $this->service->createMeetingService($name, $place, $date, $email);
            if (isset($createMeeting['error'])) {
                echo $createMeeting['error'];
                return;
            }
            header('Location: /dashboard');
            exit();
        }
    }

    public function editMeeting()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'meetingName', FILTER_SANITIZE_SPECIAL_CHARS);
            $place = filter_input(INPUT_POST, 'meetingPlace', FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_input(INPUT_POST, 'meetingDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $editMeeting = $this->service->editMeetingData($id, $name, $place, $date);
            if (isset($editMeeting['error'])) {
                echo $editMeeting['error'];
                return;
            }

            header('Location: /dashboard');
            exit();
        }
    }

    public function getMeetingData()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $meetingData = $this->service->getMeetingDataById($id);

        include __DIR__ . '/../../views/editmeeting.php';
    }

    public function confirmMeeting()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['userEmail'];
            $meetingId = filter_input(INPUT_POST, 'meetingId', FILTER_VALIDATE_INT);

            $userId = $this->authService->getUserEmailFromEmail($email);
            $this->service->addMeetingToUser($userId, $meetingId);

            header('Location: /dashboard');
            exit();
        }
    }
}
