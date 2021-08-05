<?php

namespace App\Repositories;

use App\PostMention;

class PostMentionRepository
{
    public function getCount ()
    {
        return PostMention::count();
    }
}