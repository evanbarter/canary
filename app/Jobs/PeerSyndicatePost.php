<?php

namespace App\Jobs;

use App\Peer;
use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PeerSyndicatePost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var App\Peer */
    protected Peer $peer;

    /** @var string */
    protected $post;

    /** @var string */
    protected string $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Peer $peer, $post, string $event)
    {
        $this->peer = $peer;
        $this->post = $post;
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = rtrim($this->peer->url, '/') . '/api/v1/peers/syndicate/post';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->peer->token,
        ])->post($url, [
            'post' => $this->post,
            'event' => $this->event,
        ]);

        if ($response->status() !== 200) {
            $response->throw(sprintf('Could not syndicate post to peer: %s', $this->peer->url));
        }
    }
}
