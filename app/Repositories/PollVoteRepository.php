<?php

namespace App\Repositories;

use App\PollVote;

class PollVoteRepository
{
    public function getCount ()
    {
        return PollVote::count();
    }
}