<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;
    public $content;
    public $user;

    public function __construct($user, $topic, $content) {
        $this->topic = $topic;
        $this->content = $content;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.broadcast')
            ->subject($this->topic);
    }
}