<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function scopeVerified($query)
    {
        $query->whereNotNull('token');
        $query->whereNotNull('verified_at');
    }
}
