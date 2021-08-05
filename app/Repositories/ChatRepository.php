<?php

namespace App\Repositories;

use App\Chat;

class ChatRepository
{
    public function getCount ()
    {
        return Chat::count();
    }
}