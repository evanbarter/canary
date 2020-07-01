<?php

namespace App\Http\Middleware;

use Closure;

class MediaAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $visibility = $request->media->model->post->visibility;

        if ($visibility === 0 && !auth()->user()) {
            abort(401);
        } else if ($visibility === -1 && (!auth()->user() || auth()->user()->currentAccessToken())) {
            abort(401);
        }

        return $next($request);
    }
}
