<?php

namespace App\Repositories;

use App\Website;

class WebsiteRepository
{
    public function getPersonalCount ()
    {
        return Website::whereNotNull('personal')->count();
    }

    public function getCompanyCount ()
    {
        return Website::whereNotNull('company')->count();
    }

    public function getCount ()
    {
        return $this->getPersonalCount() + $this->getCompanyCount();
    }
}