<?php

namespace App\Http\Controllers;

use App\Service\Broadcast;
use App\Services\Response;
use Illuminate\Http\Request;

class SocketController
{
    protected $response;
    protected $broadcast;

    public function __construct()
    {
        $this->response = new Response;
        $this->broadcast = new Broadcast;
    }

    public function auth(Request $request)
    {
        $auth = $this->broadcast->presenceAuth(
            $request->channel_name,
            $request->socket_id,
            $request->admin->id
        );
        return $auth;
    }
}