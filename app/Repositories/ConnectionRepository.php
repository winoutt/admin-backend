<?php

namespace App\Repositories;

use App\Connection;

class ConnectionRepository
{
    public function getCount ()
    {
        return Connection::count();
    }
}