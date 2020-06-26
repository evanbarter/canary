<?php

namespace App\Observers;

use App\Peer;
use App\Post;
use App\Jobs\PeerSyndicatePost;

class PostObserver
{
    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function saved(Post $post)
    {
        $this->notifyPeers($post, 'saved');
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        $this->notifyPeers($post, 'deleted');
    }

    /**
     *
     */
    private function notifyPeers(Post $post, string $event) {
        // Make sure this post should be syndicated and was created by a user.
        if ($post->syndicatable
            && $post->sourceable()->first()->is(auth()->user())) {
            foreach (Peer::verified()->get() as $peer) {
                PeerSyndicatePost::dispatch($peer, $post, $event);
            }
        }
    }
}
