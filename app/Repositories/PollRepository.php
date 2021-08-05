<?php

namespace App\Repositories;

use App\Poll;

class PollRepository
{
    public function getCount ()
    {
        return Poll::count();
    }
}