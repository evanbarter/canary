<?php

namespace App\Jobs;

use App\Peer;
use App\Post;
use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PeerSyndicateComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var App\Peer */
    protected Peer $peer;

    /** @var App\Post */
    protected Post $post;

    /** @var App\Peer */
    protected Comment $comment;

    /** @var string */
    protected string $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Peer $peer, Post $post, Comment $comment, string $event)
    {
        $this->peer = $peer;
        $this->post = $post;
        $this->comment = $comment;
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = rtrim($this->peer->url, '/') . '/api/v1/peers/syndicate/comment';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->peer->token,
        ])->post($url, [
            'post' => json_encode($this->post->only(['uuid'])),
            'comment' => $this->comment->toJson(),
            'event' => $this->event,
        ]);
    }
}
