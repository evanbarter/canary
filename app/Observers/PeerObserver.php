<?php

namespace App\Observers;

use App\User;
use App\Peer;
use App\Jobs\PeerHandshake;
use App\Notifications\PeerRequest;

class PeerObserver
{
    /**
     * Handle the peer "created" event.
     *
     * @param  \App\Peer  $peer
     * @return void
     */
    public function created(Peer $peer)
    {
        if (!$peer->token) {
            PeerHandshake::dispatch(
                $peer,
                auth()->user(),
                '/api/v1/peers/handshake',
                'handshake'
            );
        } else {
            User::first()->notify(new PeerRequest($peer));
        }
    }

    /**
     * Handle the peer "updated" event.
     *
     * @param  \App\Peer  $peer
     * @return void
     */
    public function updated(Peer $peer)
    {
        //
    }

    /**
     * Handle the peer "deleted" event.
     *
     * @param  \App\Peer  $peer
     * @return void
     */
    public function deleted(Peer $peer)
    {
        //
    }

    /**
     * Handle the peer "restored" event.
     *
     * @param  \App\Peer  $peer
     * @return void
     */
    public function restored(Peer $peer)
    {
        //
    }

    /**
     * Handle the peer "force deleted" event.
     *
     * @param  \App\Peer  $peer
     * @return void
     */
    public function forceDeleted(Peer $peer)
    {
        //
    }
}
