<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MeetingModel;

class MeetingService
{
    private MeetingModel $model;

    public function __construct()
    {
        $this->model = new MeetingModel();
    }

    public function createMeetingService($name, $place, $date, $createdBy)
    {
        if (empty($name) || empty($place) || empty($date)) {
            return ['error' => 'All fields are required'];
        }
        if (!$this->model->createNewMeetingQuery($name, $place, $date, $createdBy)) {
            return ['error' => 'Meeting cannot be created'];
        }
        return ['success' => true];
    }

    public function displayAllMeetings()
    {
        $meetings = $this->model->displayMeetings();
        if (!$meetings) {
            return ['error' => 'Query have not data'];
        }
        return $meetings;
    }

    public function editMeetingData($id, $name, $place, $date)
    {
        if (!$this->model->editMeetingQuery($id, $name, $place, $date)) {
            return ['error' => 'Meeting cannot be edited'];
        }
        return ['success' => true];
    }

    public function getMeetingDataById($id)
    {
        $data = $this->model->getMeetingDataByIdQuery($id);
        if (!$data) {
            return ['error' => 'Meeting ID not found'];
        }
        return $data;
    }

    public function addMeetingToUser($id, $meeting)
    {
        if (empty($id) || empty($meeting)) {
            return ['error' => 'UserID and meetingID must be passed'];
        }
        if ($this->model->checkIsMeetingsToUserExists($id, $meeting)) {
            return ['error' => 'Meeting already exists for this user'];
        }

        $meetingToUser = $this->model->addMeetingToUserQuery($id, $meeting);
        if ($meetingToUser) {
            return ['error' => 'Meetings are not found'];
        }
        return $meetingToUser;
    }

    public function getMeetingsForLoggedUser($userId)
    {
        if (empty($userId)) {
            return ['error' => 'UserID must be passed'];
        }
        $meetings = $this->model->getMeetingsForLoggedUserQuery($userId);
        if (!$meetings) {
            return ['error' => 'Meetings are not found'];
        }
        return $meetings;
    }
}
