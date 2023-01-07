<?php

namespace App\Repositories;

use App\Models\OrganizerNotification;

class OrganizerNotificationRepository extends BaseRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new OrganizerNotification();
    }

    public function getLatestData(): ?object
    {
        return $this->model->orderBy('id', 'DESC')->first();
    }
}
