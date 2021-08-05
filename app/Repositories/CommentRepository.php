<?php

namespace App\Repositories;

use App\Comment;
use Carbon\Carbon;
use Exception;

class CommentRepository
{
    public function getCount ()
    {
        return Comment::count();
    }

    public function getReportingsCount ()
    {
        return Comment::has('reportings')->count();
    }

    public function monthlyStatistics ()
    {
        $now = Carbon::now()->toISOString();
        $monthAgo = Carbon::now()->subDays(30)->toISOString();
        return Comment::select(['id', 'created_at'])
            ->whereBetween('created_at', [$monthAgo, $now])
            ->get()
            ->countBy('created_date');
    }

    public function getLatest()
    {
        return Comment::latest()->limit(25)->get();
    }

    public function getFromId($id)
    {
        $comment = Comment::find($id);
        if (!$comment) throw new Exception('Comment not found');
        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->getFromId($id);
        $comment->forceDelete();
        return $comment;
    }

    public function search($term)
    {
        return Comment::where('id', $term)
            ->orWhereHas('user', function($query) use ($term) {
                $query->where('email', $term);
            })
            ->orderByDesc('id')
            ->limit(25)
            ->get();
    }
}