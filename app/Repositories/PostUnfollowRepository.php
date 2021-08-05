<?php

namespace App\Repositories;

use App\PostUnfollow;

class PostUnfollowRepository
{
    public function getCount ()
    {
        return PostUnfollow::count();
    }
}