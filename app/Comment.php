<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'mentions',
        'hashtags',
        'votes'
    ];

    protected $with = [
        'user'
    ];

    public function reportings()
    {
        return $this->morphMany(Reporting::class, 'reportable');
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentions()
    {
        return $this->hasMany(CommentMention::class);
    }

    public function hashtags()
    {
        return $this->hasMany(CommentHashtag::class);
    }
    
    public function votes()
    {
        return $this->hasMany(CommentVote::class);
    }
}
