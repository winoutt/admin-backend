<?php

namespace App\Repositories;

use App\CommentVote;

class CommentVoteRepository
{
    public function getCount ()
    {
        return CommentVote::count();
    }
}