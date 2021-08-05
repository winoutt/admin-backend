<?php

namespace App\Services;

class Environment
{
    public function getCorsOrigin()
    {
        return env('APP_ENV') === 'local' ? env('APP_CORS_ORIGIN') : 'app://.';
    }
}