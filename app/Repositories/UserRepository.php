<?php

namespace App\Repositories;

use App\User;
use Carbon\Carbon;
use Exception;

class UserRepository
{
    public function getCount ()
    {
        return User::count();
    }

    public function topCountries ()
    {
        return User::select('country')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('country')
            ->where('country', '!=', null)
            ->orderByDesc('count')
            ->limit(10)
            ->get();
    }

    public function monthlyStatistics ()
    {
        $now = Carbon::now()->toISOString();
        $monthAgo = Carbon::now()->subDays(30)->toISOString();
        return User::select(['id', 'created_at'])
            ->whereBetween('created_at', [$monthAgo, $now])
            ->get()
            ->countBy('created_date');
    }

    public function getReportingsCount ()
    {
        return User::has('reported')->count();
    }

    public function getCountByGender ($gender)
    {
        return User::where('gender', $gender)->count();
    }

    public function getEmails()
    {
        return User::get('email')->toArray();
    }

    public function getFromEmail ($email)
    {
        $user = User::withTrashed()->where('email', $email)->first();
        if (!$user) throw new Exception('User not found');
        return $user;
    }

    public function getLatest()
    {
        return User::withTrashed()->latest()->limit(25)->get();
    }

    public function getFromId($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) throw new Exception('User not found');
        return $user;
    }

    public function getTrashedFromId($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) throw new Exception('User not found in trash');
        return $user;
    }

    public function getOnlineCount()
    {
        return User::where('is_online', true)->count();
    }

    public function getBannedCount()
    {
        return User::onlyTrashed()->count();
    }

    public function search($term)
    {
        $pattern = '%'.$term.'%';
        return User::withTrashed()
            ->where('id', $term)
            ->orWhere('first_name', 'like', $pattern)
            ->orWhere('last_name', 'like', $pattern)
            ->orWhere('username', 'like', $pattern)
            ->orWhere('email', 'like', $pattern)
            ->orWhere('city', 'like', $pattern)
            ->orWhere('gender', $term)
            ->orWhere('country', $term)
            ->orderByDesc('id')
            ->limit(25)
            ->get();
    }

    public function block($id)
    {
        $user = $this->getFromId($id);
        $user->delete();
        return $user;
    }

    public function unblock($id)
    {
        $user = $this->getTrashedFromId($id);
        $user->restore();
        return $user;
    }
}