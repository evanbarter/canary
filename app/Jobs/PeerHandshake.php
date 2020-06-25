<?php

namespace App\Jobs;

use App\Peer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PeerHandshake implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var App\Peer */
    protected Peer $peer;

    /** @var App\User */
    protected User $user;

    /** @var string */
    protected $path;

    /** @var string */
    protected $token_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Peer $peer, User $user, string $path, string $token_type)
    {
        $this->user = $user;
        $this->peer = $peer;
        $this->path = $path;
        $this->token_type = $token_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = $this->peer->createToken($this->token_type, [$this->token_type])->plainTextToken;
        $url = rtrim($this->peer->url, '/') . $this->path;
        $headers = [];

        if ($this->peer->token) {
            $headers['Authorization'] = 'Bearer ' . $this->peer->token;
        }

        $response = Http::withHeaders($headers)->post($url, [
            'url' => config('app.url'),
            'name' => $this->user->name,
            'token' => $token,
        ]);

        if ($response->status() !== 200) {
            $response->throw(sprintf('Error establishing connection to peer: %s', $this->peer->url));
        }
    }
}
