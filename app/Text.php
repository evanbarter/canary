<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function post()
    {
        return $this->morphOne(Post::class, 'postable');
    }

    public function getTitleForSlugAttribute()
    {
        return $this->title;
    }
}
