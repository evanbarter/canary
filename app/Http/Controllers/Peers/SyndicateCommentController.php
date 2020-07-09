<?php

namespace App\Http\Controllers\Peers;

use App\Post;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeerRequest;

class SyndicateCommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\PeerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PeerRequest $request)
    {
        $post_data = json_decode($request->input('post'));
        $comment_data = json_decode($request->input('comment'));

        $post = Post::where('uuid', $post_data->uuid)->firstOrFail();
        $comment = Comment::where('uuid', $comment_data->uuid)->first();
        $peer = $request->peer();

        switch ($request->input('event')) {
            case 'deleted':
                $comment->delete();
                break;
            case 'saved':
                if (!$comment) {
                    $comment = new Comment;
                    $comment->comment = $comment_data->comment;
                    $comment->sourceable()->associate($peer);
                    $comment->commentable()->associate($post);
                    $comment->save();
                } else {

                }
                break;
        }
    }
}
