<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'comments',
        'favourites',
        'mentions',
        'content',
        'album',
        'poll',
        'stars',
        'unfollows',
        'authorStarViews',
        'hashtags'
    ];

    protected $with = [
        'team',
        'user',
        'content',
        'poll',
        'album'
    ];

    public function content()
    {
        return $this->hasOne(PostContent::class);
    }

    public function reportings()
    {
        return $this->morphMany(Reporting::class, 'reportable');
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function album ()
    {
        return $this->hasMany(PostAlbumPhoto::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function mentions()
    {
        return $this->hasMany(PostMention::class);
    }

    public function stars()
    {
        return $this->hasMany(Star::class);
    }

    public function unfollows()
    {
        return $this->hasMany(PostUnfollow::class);
    }

    public function authorStarViews()
    {
        return $this->hasOne(AuthorStarView::class);
    }

    public function hashtags()
    {
        return $this->hasMany(PostHashtag::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
