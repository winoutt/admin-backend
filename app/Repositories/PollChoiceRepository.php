<?php

namespace App\Repositories;

use App\PollChoice;

class PollChoiceRepository
{
    public function getCount ()
    {
        return PollChoice::count();
    }
}