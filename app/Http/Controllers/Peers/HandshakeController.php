<?php

namespace App\Http\Controllers\Peers;

use App\Peer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandshakeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Peer::create($request->only(['url', 'name', 'token']));
        return response()->json(['success' => true]);
    }
}
