<?php

namespace App\Repositories;

use App\Star;
use Carbon\Carbon;

class StarRepository
{
    public function getCount ()
    {
        return Star::count();
    }

    public function monthlyStatistics ()
    {
        $now = Carbon::now()->toISOString();
        $monthAgo = Carbon::now()->subDays(30)->toISOString();
        return Star::select(['id', 'created_at'])
            ->whereBetween('created_at', [$monthAgo, $now])
            ->get()
            ->countBy('created_date');
    }
}