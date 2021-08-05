<?php

namespace App\Repositories;

use App\Hashtag;

class HashtagRepository
{
    public function getCount ()
    {
        return Hashtag::count();
    }
}