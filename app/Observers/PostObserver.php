<?php

namespace App\Observers;

use App\Peer;
use App\Post;
use App\Jobs\PeerSyndicatePost;

class PostObserver
{
    /**
     * Handle the post "saving" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function saving(Post $post)
    {
        $title = $post->postable->title_for_slug ?: \Str::uuid();
        $post->slug = \Str::slug($title);
    }

    /**
     * Handle the post "saved" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function saved(Post $post)
    {
        $this->notifyPeers($post, 'saved');
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        if ($post->isDirty('visibility')) {
            $visibility = $post->visibility;
            $old_visibility = $post->getOriginal('visibility');
            if ($visibility === '-1' && $old_visibility !== -1) {
                $this->notifyPeers($post, 'deleted');
            }
        }
    }

    /**
     * Handle the post "deleting" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleting(Post $post)
    {
        $this->notifyPeers($post, 'deleted');
    }

    /**
     *
     */
    private function notifyPeers(Post $post, string $event)
    {
        // Make sure this post should be syndicated and was created by a user.
        if ($post->syndicatable) {
            foreach (Peer::verified()->get() as $peer) {
                PeerSyndicatePost::dispatch(
                    $peer,
                    $post->prepareForSyndication($event),
                    $event
                );
            }
        }
    }
}
