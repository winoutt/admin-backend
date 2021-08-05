<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentMention extends Model
{
    use SoftDeletes;
    protected $table = 'comment_mention';
}
