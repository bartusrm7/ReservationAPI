<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\AuthService;
use App\Services\MeetingService;

class DashboardController
{
    private AuthService $authService;
    private MeetingService $service;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->service = new MeetingService();
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['userEmail'])) {
            header('Location: /signin');
            exit();
        }
        $email = $_SESSION['userEmail'];
        $name = $_SESSION['userName'];
        $buisness = $_SESSION['buisness'] ?? null;

        $userId = $this->authService->getUserEmailFromEmail($email);
        $meetings = $this->service->displayAllMeetings();
        $meetingsToLoggedUser = $this->service->getMeetingsForLoggedUser($userId);

        $meetingsIds = [];
        if (!$buisness) {
            foreach ($meetingsToLoggedUser as $meeting) {
                if (isset($meeting['meetingId'])) {
                    $meetingsIds[] = $meeting['meetingId'];
                }
            }
        }
        include __DIR__ . '/../../views/dashboard.php';
    }
}
