<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController
{
    private $response;
    private $userRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->userRepo = new UserRepository;
    }

    public function list()
    {
        $users = $this->userRepo->getLatest();
        return $this->response->ok($users);
    }

    public function read($id)
    {
        try {
            $user = $this->userRepo->getFromId($id);
            return $this->response->ok($user);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function search(Request $request) {
        $validator = Validator::make($request->query(), [
            'term' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->unprocessable($validator);
        }
        $users = $this->userRepo->search($request->query('term'));
        return $this->response->ok($users);
    }

    public function block($id)
    {
        try {
            $user = $this->userRepo->block($id);
            return $this->response->ok($user);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function unblock($id)
    {
        try {
            $user = $this->userRepo->unblock($id);
            return $this->response->ok($user);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }
}