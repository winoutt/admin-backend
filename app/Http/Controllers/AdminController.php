<?php

namespace App\Http\Controllers;

use App\Repositories\AdminRepository;
use App\Services\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController
{
    private $response;
    private $adminRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->adminRepo = new AdminRepository;
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|min:6',
            'newPassword' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return $this->response->unprocessable($validator);
        }
        try {
            $adminId = $request->admin->id;
            $currentPassword = $request->currentPassword;
            $isValidCurrentPassword = $this->adminRepo
                ->isCurrentPassword($adminId,$currentPassword);
            if (!$isValidCurrentPassword) {
                throw new Exception('Invalid current password');
            }
            $this->adminRepo->updatePassword($adminId, $request->newPassword);
            return $this->response->ok(['isUpdated' => true]);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }
}