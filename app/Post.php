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

    public function user()
    {
        return $this->belongsTo(User::class);
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
