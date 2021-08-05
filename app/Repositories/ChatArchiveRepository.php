<?php

namespace App\Repositories;

use App\ChatArchive;

class ChatArchiveRepository
{
    public function getCount ()
    {
        return ChatArchive::count();
    }
}