<?php

namespace App\Http\Controllers;

use App\Jobs\BroadcastMailJob;
use App\Repositories\UserRepository;
use App\Services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class MailController
{
    private $response;
    private $userRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->userRepo = new UserRepository;
    }

    public function send (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'nullable|email',
            'subject' => 'required',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->unprocessable($validator);
        }
        $to = $request->to;
        $receivers = $to ? [$to] : $this->userRepo->getEmails();
        $receivers = collect($receivers);
        $receivers->each(function ($receiver) use ($request) {
            $subject = $request->subject;
            $message = $request->message;
            dispatch((new BroadcastMailJob($receiver, $subject, $message))
                ->onQueue('admin-emails'));
        });
        return $this->response->ok([
            'isSent' => true,
            'receiversCount' => $receivers->count(),
        ]);
    }
}