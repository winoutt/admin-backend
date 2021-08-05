<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidJwtTokenData;
use App\Exceptions\NoAuthToken;
use App\Repositories\AdminRepository;
use App\Services\Cookie;
use App\Services\JWT;
use App\Services\Response;
use Closure;
use Exception;

class ApiAuthMiddleware
{
    private $response;
    private $jwt;
    private $adminRepo;
    private $cookie;

    public function __construct()
    {
        $this->response = new Response;
        $this->jwt = new JWT;
        $this->adminRepo = new AdminRepository;
        $this->cookie = new Cookie;
    }

    public function refreshAuthToken($next, $request, $adminId)
    {
        $authToken = $this->jwt->authToken($adminId);
        $response = $next($request);
        $response = $this->cookie->setAuthToken($response, $authToken);
        return $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = $request->cookie('auth_token');
            if (!$token) throw new NoAuthToken('No bearer token');
            $authToken = $this->jwt->verify($token);
            $adminId = $authToken->getClaim('admin_id');
            $request->admin = $this->adminRepo->getFromId($adminId);
            $this->jwt->validate($authToken);
            return $next($request);
        } catch (NoAuthToken $e) {
            try {
                $refreshToken = $request->cookie('refresh_token');
                if (!$refreshToken) throw new Exception('No refresh token');
                $admin = $this->adminRepo->getFromRefreshToken($refreshToken);
                return $this->refreshAuthToken($next, $request, $admin->id);
            } catch (Exception $e) {
                return $this->response->unauthorized('Unauthorized access');
            }
        } catch (InvalidJwtTokenData $e) {
            try {
                $admin = $request->admin;
                $cookieRefreshToken = $request->cookie('refresh_token');
                $isValidRefresh = $admin->refresh_token === $cookieRefreshToken;
                if (!$isValidRefresh) throw new Exception('Invalid refresh token');
                return $this->refreshAuthToken($next, $request, $admin->id);
            } catch (Exception $e) {
                return $this->response->unauthorized('Unauthorized access');
            }
        } catch (Exception $e) {
            return $this->response->unauthorized('Unauthorized access');
        }
    }
}
