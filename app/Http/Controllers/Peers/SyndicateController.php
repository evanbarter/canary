<?php

namespace App\Http\Controllers\Peers;

use App\Peer;
use App\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeerRequest;
use App\Actions\CreateTextPost;
use App\Actions\UpdateTextPost;

class SyndicateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PeerRequest $request)
    {
        $post_data = json_decode($request->input('post'));

        $post = Post::where('uuid', $post_data->uuid)->first();
        $peer = $request->peer();

        switch ($request->input('event')) {
            case 'deleted':
                $post->delete();
                break;
            case 'saved':
                switch ($post_data->postable_type) {
                    case 'text':
                        if (!$post) {
                            CreateTextPost::dispatch([
                                'source' => $peer,
                                'uuid' => $post_data->uuid,
                                'created_at' => $post_data->created_at,
                                'updated_at' => $post_data->updated_at,
                                'title' => $post_data->postable->title,
                                'text' => $post_data->postable->text,
                            ]);
                        } else {
                            UpdateTextPost::dispatch([
                                'post' => $post,
                                'updated_at' => $post_data->updated_at,
                                'title' => $post_data->postable->title,
                                'text' => $post_data->postable->text,
                            ]);
                        }
                        break;
                }
                break;
        }
    }
}
