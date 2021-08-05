<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'votes',
        'choices'
    ];

    protected $with = [
        'choices',
    ];

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function choices()
    {
        return $this->hasMany(PollChoice::class);
    }
}
