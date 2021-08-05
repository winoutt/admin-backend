<?php

namespace App\Repositories;

use App\LinkPreview;

class LinkPreviewRepository
{
    public function getCount ()
    {
        return LinkPreview::count();
    }
}