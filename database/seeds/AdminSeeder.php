<?php

use App\Admin;
use App\Services\JWT;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    private $jwt;

    function __construct()
    {
        $this->jwt = new JWT;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'email' => 'admin@winoutt.com',
            'password' => Hash::make('password'),
            'refresh_token' => $this->jwt->refreshToken(),
        ]);
    }
}
