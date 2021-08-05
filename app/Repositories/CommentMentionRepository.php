<?php

namespace App\Repositories;

use App\CommentMention;

class CommentMentionRepository
{
    public function getCount ()
    {
        return CommentMention::count();
    }
}