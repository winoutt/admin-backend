<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'lastMessage'
    ];

    public function lastMessage()
    {
        return $this->hasOne(LastMessage::class);
    }
}
