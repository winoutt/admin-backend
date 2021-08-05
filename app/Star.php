<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Star extends Model
{
    use SoftDeletes;

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
