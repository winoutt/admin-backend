<?php

namespace App\Repositories;

use App\AuthorStarView;

class AuthorStarViewRepository
{
    public function getCount ()
    {
        return AuthorStarView::count();
    }
}