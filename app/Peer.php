<?php

namespace App;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Peer extends Model
{
    use HasApiTokens;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function getAuthIdentifier()
    {
        return $this->{$this->getKeyName()};
    }
}
