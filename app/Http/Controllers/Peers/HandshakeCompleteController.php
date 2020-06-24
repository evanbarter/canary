<?php

namespace App\Http\Controllers\Peers;

use App\Peer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandshakeCompleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $peer = Peer::where('url', $request->input('url'))->first();
        $peer->update([
            'verified_at' => now(),
            'token' => $request->input('token'),
        ]);
    }
}
