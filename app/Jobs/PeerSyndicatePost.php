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

    /** @var App\Post|array */
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

        // For certain events, we might not have a model.
        if (in_array($this->event, ['deleted'])) {
            $post = json_encode($this->post);
        } else {
            $transformer = '\App\Transformers\\' . ucfirst($this->post->postable_type) . 'PostTransformer';
            if ($this->event !== 'deleted' && class_exists($transformer)) {
                $post = fractal()
                   ->item($this->post)
                   ->transformWith(new $transformer())
                   ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                   ->toJson();
            } else {
                $post = $this->post->toJson();
            }
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->peer->token,
        ])->post($url, [
            'post' => $post,
            'event' => $this->event,
        ]);
    }
}
