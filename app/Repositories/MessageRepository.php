<?php

namespace App\Repositories;

use App\Message;

class MessageRepository
{
    public function getCount ()
    {
        return Message::count();
    }
}