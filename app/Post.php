<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
            if (!$post->uuid) {
                $post->uuid = \Str::uuid();
            }
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
        $query->where('visibility', 1);
    }

    public function scopeSyndicated($query)
    {
        $query->whereHasMorph(
            'sourceable',
            'App\Peer'
        );
    }

    public function scopeLocal($query)
    {
        $query->whereHasMorph(
            'sourceable',
            'App\User'
        );
    }

    public function scopeSyndicatable($query)
    {
        $query->whereIn('visibility', [1, 0]);
        $query->whereHasMorph(
            'sourceable',
            'App\User'
        );
    }

    public function getSyndicatableAttribute()
    {
        return in_array($this->visibility, [1, 0])
            && $this->sourceable()->first()->is(auth()->user());
    }

    public function getSyndicatedAttribute()
    {
        return !$this->sourceable()->first()->is(auth()->user());
    }
}
