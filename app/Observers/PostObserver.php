<?php

namespace App\Observers;

use App\Post;
use App\Jobs\PeerSyndicatePost;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        $this->notifyPeers($post, 'created');
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        $this->notifyPeers($post, 'updated');
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
        // Make sure this post was created by the user.
        if ($post->sourceable()->first()->is(auth()->user())) {
            foreach (Peer::verified()->get() as $peer) {
                PeerSyndicatePost::dispath($peer, $post, $event);
            }
        }
    }
}
