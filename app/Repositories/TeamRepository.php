<?php

namespace App\Repositories;

use App\Team;

class TeamRepository
{
    public function getCount ()
    {
        return Team::count();
    }
}