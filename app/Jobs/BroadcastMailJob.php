<?php

namespace App\Jobs;

use App\Mail\BroadcastMail;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Mail;

class BroadcastMailJob extends Job
{
    private $email;
    private $subject;
    private $message;
    private $userRepo;

    public function __construct($email, $subject, $message)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->userRepo = new UserRepository;
    }

    public function handle()
    {
        try {
            $user = $this->userRepo->getFromEmail($this->email);
        } catch (Exception $e) {
            $user = null;
        }
        $mail = new BroadcastMail($user, $this->subject, $this->message);
        Mail::to($this->email)->send($mail);
    }
}
