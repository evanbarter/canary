<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->uuid = \Str::uuid();
        });
    }

    public function sourceable()
    {
        return $this->morphTo();
    }

    public function postable()
    {
        return $this->morphTo();
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 1);
    }
}
