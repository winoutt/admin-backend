<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollChoice extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'votes'
    ];

    public function votes()
    {
        return $this->hasMany(PollVote::class, 'choice_id');
    }
}
