<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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

        static::creating(function ($comment) {
            if (!$comment->uuid) {
                $comment->uuid = \Str::uuid();
            }
        });
    }

    public function sourceable()
    {
        return $this->morphTo();
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function getSyndicatableAttribute()
    {
        return $this->sourceable()->first()->is(auth()->user());
    }

    public function getSyndicatedAttribute()
    {
        return !$this->sourceable()->first()->is(auth()->user());
    }
}
