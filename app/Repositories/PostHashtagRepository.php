<?php

namespace App\Repositories;

use App\PostHashtag;

class PostHashtagRepository
{
    public function getCount ()
    {
        return PostHashtag::count();
    }
}