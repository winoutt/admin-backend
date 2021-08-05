<?php

namespace App\Repositories;

use App\PostAlbumPhoto;

class PostAlbumPhotoRepository
{
    public function getCount ()
    {
        return PostAlbumPhoto::count();
    }
}