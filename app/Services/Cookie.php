<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

class Cookie
{
    public function setAuthToken($response, $authToken)
    {
        $options = ['auth_token', $authToken, time() + 3600, '/', null, true, true, false, 'none'];
        $cookie = new SymfonyCookie(...$options);
        $response->withCookie($cookie);
        return $response;
    }

    public function setRefreshToken ($response, $refreshToken) {
        $options = ['refresh_token', $refreshToken, 0, '/', null, true, true, false, 'none'];
        $cookie = new SymfonyCookie(...$options);
        $response->withCookie($cookie);
        return $response;
    }
}