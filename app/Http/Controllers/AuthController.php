<?php

namespace App\Http\Controllers;

use App\Repositories\AdminRepository;
use App\Services\Cookie;
use App\Services\JWT;
use App\Services\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
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

    public function login (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:admins|max:255',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return $this->response->unprocessable($validator);
        }
        try {
            $isValidCredentials = $this->adminRepo
                ->isValidAuthCredentials($request->email, $request->password);
            if (!$isValidCredentials) {
                throw new Exception('Invalid credentials');
            }
            $admin = $this->adminRepo->getFromEmail($request->email);
            $authToken = $this->jwt->authToken($admin->id);
            $response = $this->response->ok(['token' => $authToken]);
            $response = $this->cookie->setAuthToken($response, $authToken);
            $response = $this->cookie
                ->setRefreshToken($response, $admin->refresh_token);
            return $response;
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function check()
    {
        return $this->response->ok(['has_auth' => true]);
    }
}
