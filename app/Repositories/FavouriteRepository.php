<?php

namespace App\Repositories;

use App\Favourite;

class FavouriteRepository
{
    public function getCount ()
    {
        return Favourite::count();
    }
}