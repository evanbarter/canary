<?php

namespace App\Providers;

use App\Peer;
use App\Post;
use App\Observers\PeerObserver;
use App\Observers\PostObserver;
use App\Http\Requests\PeerRequest;
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
            'image' => 'App\Image',
            'peer' => 'App\Peer',
            'post' => 'App\Post',
            'text' => 'App\Text',
            'user' => 'App\User',
        ]);

        Peer::observe(PeerObserver::class);
        Post::observe(PostObserver::class);

        $this->app->resolving(PeerRequest::class, function ($request, $app) {
            PeerRequest::createFrom($app['request'], $request);
        });
    }
}
