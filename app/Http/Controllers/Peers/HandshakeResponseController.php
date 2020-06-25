<?php

namespace App\Http\Controllers\Peers;

use App\Peer;
use App\Jobs\PeerHandshake;
use App\Notifications\PeerComplete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandshakeResponseController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $peer = Peer::where('url', $request->input('url'))->firstOrFail();
        $peer->update([
            'verified_at' => now(),
            'name' => $request->input('name'),
            'token' => $request->input('token'),
        ]);
        $peer->tokens()->where('name', 'handshake')->delete();

        User::first()->notify(new PeerComplete($peer));

        PeerHandshake::dispatch(
            $peer,
            auth()->user(),
            '/api/v1/peers/handshake/complete',
            'peer'
        );
    }
}
