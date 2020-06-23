<?php

namespace App\Observers;

use App\Peer;
use App\Jobs\PeerInitiateHandshake;

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
            PeerInitiateHandshake::dispatch($peer, auth()->user());
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
