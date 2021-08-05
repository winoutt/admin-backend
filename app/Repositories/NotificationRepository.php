<?php

namespace App\Repositories;

use App\Notification;

class NotificationRepository
{
    public function getCount ()
    {
        return Notification::count();
    }
}