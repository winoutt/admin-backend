<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'archives',
        'lastMessage'
    ];

    public function archives()
    {
        return $this->hasMany(ChatArchive::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(LastMessage::class);
    }
}
