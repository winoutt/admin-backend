<?php

namespace App\Repositories;

use App\Unfollow;

class UnfollowRepository
{
    public function getCount ()
    {
        return Unfollow::count();
    }
}