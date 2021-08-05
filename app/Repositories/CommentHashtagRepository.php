<?php

namespace App\Repositories;

use App\CommentHashtag;

class CommentHashtagRepository
{
    public function getCount ()
    {
        return CommentHashtag::count();
    }
}