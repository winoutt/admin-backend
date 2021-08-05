<?php

namespace App;

use App\Traits\SoftCascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes, SoftCascadeDeletes;

    protected static $softCascade = [
        'posts',
        'notes',
        'reportings',
        'postMentions',
        'favourites',
        'comments',
        'commentMentions',
        'chatArchives',
        'commentVotes',
        'settings',
        'connections',
        'connectionConnections',
        'website',
        'unfollows',
        'unfollowConnections',
        'notifications',
        'notificationConnections',
        'messages',
        'chats',
        'chatConnections',
        'stars',
        'authorStarView',
        'postUnfollows',
        'pollVotes'
    ];

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function reported()
    {
        return $this->morphMany(Reporting::class, 'reportable');
    }

    public function reportings()
    {
        return $this->hasMany(Reporting::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function postMentions()
    {
        return $this->hasMany(PostMention::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentMentions()
    {
        return $this->hasMany(CommentMention::class);
    }

    public function chatArchives()
    {
        return $this->hasMany(ChatArchive::class);
    }

    public function commentVotes()
    {
        return $this->hasMany(CommentVote::class);
    }

    public function settings()
    {
        return $this->hasOne(Settings::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function connectionConnections()
    {
        return $this->hasMany(Connection::class, 'connection_id');
    }

    public function website()
    {
        return $this->hasOne(Website::class);
    }

    public function unfollows()
    {
        return $this->hasMany(Unfollow::class);
    }

    public function unfollowConnections()
    {
        return $this->hasMany(Unfollow::class, 'connection_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function notificationConnections()
    {
        return $this->hasMany(Notification::class, 'connection_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function chatConnections()
    {
        return $this->hasMany(Chat::class, 'connection_id');
    }

    public function stars()
    {
        return $this->hasMany(Star::class);
    }

    public function authorStarView()
    {
        return $this->hasMany(AuthorStarView::class);
    }

    public function postUnfollows()
    {
        return $this->hasMany(PostUnfollow::class);
    }

    public function pollVotes()
    {
        return $this->hasMany(PollVote::class);
    }
}
