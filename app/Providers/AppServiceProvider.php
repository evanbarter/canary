<?php

namespace App\Providers;

use App\Peer;
use App\Observers\PeerObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'user' => 'App\User',
            'peer' => 'App\Peer',
            'text' => 'App\Text',
            'image' => 'App\Image',
        ]);

        Peer::observe(PeerObserver::class);
    }
}
