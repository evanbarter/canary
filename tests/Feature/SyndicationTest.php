<?php

namespace Tests\Feature;

use App\User;
use App\Peer;
use App\Post;
use App\Text;
use App\Http\Livewire\Post\ListPosts;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SyndicationTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\User */
    protected $user = null;

    /** @var \App\Peer */
    protected $peer = null;

    /** @var string */
    protected $token = '';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->peer = factory(Peer::class)->create(['verified_at' => now()]);
        $this->token = $this->user->createToken(sprintf('%s token for %s', 'Peer', $this->peer->url), [sprintf('peer:%d:%s', $this->peer->id, 'peer')])->plainTextToken;
    }

    /** @test */
    public function will_reject_unverified_peer_posts()
    {
        $this->peer->update(['verified_at' => null]);

        $text = factory(Text::class)->create();
        $post = new Post(factory(Post::class)->raw());
        $post = $post->postable()->associate($text)
            ->sourceable()->associate($this->peer)
            ->prepareForSyndication('saved');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $post,
            'event' => 'saved',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function will_accept_peer_posts()
    {
        $text = factory(Text::class)->create();
        $post = new Post(factory(Post::class)->raw());
        $post = $post->postable()->associate($text)
            ->sourceable()->associate($this->peer)
            ->prepareForSyndication('saved');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $post,
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $this->actingAs($this->user);

        $this->assertCount(1, Post::syndicated()->get());

        Livewire::test(ListPosts::class)
            ->set('feed', true)
            ->assertSee($text->title);
    }
}