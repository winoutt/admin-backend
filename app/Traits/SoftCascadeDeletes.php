<?php

namespace App\Traits;

trait SoftCascadeDeletes
{
    public static function boot() {
        parent::boot();
        static::deleting(function($user) {
            foreach(self::$softCascade as $cascade) {
                $user->$cascade()
                    ->get('id')
                    ->each(function($relation) {
                        $relation->delete();
                    });
            }
        });
        static::restored(function($user) {
            foreach(self::$softCascade as $cascade) {
                $user->$cascade()
                    ->onlyTrashed()
                    ->get('id')
                    ->each(function($relation) {
                        $relation->restore();
                    });
            }
        });
    }
}