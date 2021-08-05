<?php

namespace App\Repositories;

use App\Poll;
use App\Post;
use App\PostAlbumPhoto;
use App\PostContent;
use Carbon\Carbon;
use Exception;

class PostRepository
{
    public function getCount ()
    {
        return Post::count();
    }

    public function getCountByType ($type)
    {
        switch ($type) {
            case 'text':
                return Post::doesnthave('content')->count();
                break;
            case 'album':
                return PostAlbumPhoto::groupBy('post_id')->count();
                break;
            case 'poll':
                return Poll::count();
                break;
            default:
                return PostContent::where('type', $type)->count();
        }
    }

    public function getReportingsCount ()
    {
        return Post::has('reportings')->count();
    }

    public function monthlyStatistics ()
    {
        $now = Carbon::now()->toISOString();
        $monthAgo = Carbon::now()->subDays(30)->toISOString();
        return Post::select(['id', 'created_at'])
            ->whereBetween('created_at', [$monthAgo, $now])
            ->get()
            ->countBy('created_date');
    }

    public function getLatest()
    {
        return Post::latest()->limit(25)->get();
    }

    public function getFromId($id)
    {
        $post = Post::find($id);
        if (!$post) throw new Exception('Post not found');
        return $post;
    }

    public function delete($id)
    {
        $post = $this->getFromId($id);
        $post->forceDelete();
        return $post;
    }

    public function search($term)
    {
        $posts = Post::where('id', $term);
        switch ($term) {
            case 'text':
                $posts->orWhere(function($query) {
                    $query->doesnthave('content')->where('caption', '!=', null);
                });
                break;
            case 'album':
                $posts->orWhereHas('album');
                break;
            case 'poll':
                $posts->orWhereHas('poll');
                break;
            default:
                $posts->orWhereHas('content', function ($query) use ($term) {
                    $query->where('type', $term);
                });
        }
        $posts->orWhereHas('user', function($query) use ($term) {
            $query->where('email', $term);
        });
        return $posts->orderByDesc('id')->limit(25)->get();
    }
}