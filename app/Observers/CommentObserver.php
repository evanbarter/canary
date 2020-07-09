<?php

namespace App\Observers;

use App\Comment;
use App\Jobs\PeerSyndicateComment;

class CommentObserver
{
    /**
     * Handle the comment "saved" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function saved(Comment $comment)
    {
        $this->notifyPeer($comment, 'saved');
    }

    /**
     * Handle the comment "deleting" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleting(Comment $comment)
    {
        //
    }

    private function notifyPeer(Comment $comment, string $event)
    {
        if ($comment->syndicatable) {
            PeerSyndicateComment::dispatch(
                $comment->commentable->sourceable,
                $comment->commentable,
                $comment,
                $event
            );
        }
    }
}
