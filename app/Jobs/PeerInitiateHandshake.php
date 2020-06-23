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

class PeerInitiateHandshake implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var App\Peer */
    protected Peer $peer;

    /** @var App\User */
    protected User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Peer $peer, User $user)
    {
        $this->peer = $peer;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = $this->peer->createToken('handshake', ['handshake'])->plainTextToken;
        $url = rtrim($this->peer->url, '/') . '/api/v1/peers/handshake';

        $response = Http::post($url, [
            'url' => config('app.url'),
            'name' => $this->user->name,
            'token' => $token,
        ]);

        if ($response->status() !== 200) {
            $response->throw(sprintf('Error establishing connection to peer: %s', $this->peer->url));
        }
    }
}
