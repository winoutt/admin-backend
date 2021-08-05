<?php

namespace App\Repositories;

use App\Admin;
use Exception;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    public function isValidAuthCredentials($email, $password)
    {
        $admin = Admin::where('email', $email)->first();
        if (!$admin) throw new Exception('Email not exists');
        $isValidPassword = Hash::check($password, $admin->password);
        if (!$isValidPassword) throw new Exception('Invalid password');
        return true;
    }

    public function getFromEmail($email)
    {
        $admin = Admin::where('email', $email)->first();
        if (!$admin) throw new Exception('Admin not exists');
        return $admin;
    }

    public function getFromId($id)
    {
        $admin = Admin::find($id);
        if (!$admin) throw new Exception('Admin not exists');
        return $admin;
    }

    public function isCurrentPassword($id, $password)
    {
        $admin = $this->getFromId($id);
        return Hash::check($password, $admin->password);
    }

    public function updatePassword($id, $password)
    {
        $admin = $this->getFromId($id);
        $admin->update(['password' => Hash::make($password)]);
    }

    public function getFromRefreshToken($refreshToken)
    {
        $admin = Admin::where('refresh_token', $refreshToken)->first();
        if (!$admin) throw new Exception('Admin not found');
        return $admin;
    }
}