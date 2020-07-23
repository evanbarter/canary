<?php

namespace Tests\Feature;

use App\User;
use App\Peer;
use App\Post;
use App\Text;
use App\Comment;
use App\Http\Livewire\Post\ListPosts;
use App\Http\Livewire\Post\ViewPost;
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

    /** @var \App\Post */
    protected $post = null;

    /** @var \App\Comment */
    protected $comment = null;

    /** @var string */
    protected $token = '';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->peer = factory(Peer::class)->create(['verified_at' => now()]);
        $this->token = $this->user->createToken(sprintf('%s token for %s', 'Peer', $this->peer->url), [sprintf('peer:%d:%s', $this->peer->id, 'peer')])->plainTextToken;

        $post = new Post(factory(Post::class)->raw());
        $post
            ->postable()->associate(factory(Text::class)->create())
            ->sourceable()->associate($this->peer);
        $this->post = $post;

        $comment = new Comment(factory(Comment::class)->raw());
        $comment
            ->commentable()->associate($post)
            ->sourceable()->associate(factory(User::class)->create());
        $this->comment = $comment;
    }

    /** @test */
    public function will_reject_unverified_peers()
    {
        $this->peer->update(['verified_at' => null]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $this->post->prepareForSyndication('saved'),
            'event' => 'saved',
        ]);

        $response->assertStatus(403);

        $this->actingAs($this->user);
        $this->assertCount(0, Post::syndicated()->get());
    }

    /** @test */
    public function will_accept_peer_posts()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $this->post->prepareForSyndication('saved'),
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $this->actingAs($this->user);

        $this->assertCount(1, Post::syndicated()->get());

        Livewire::test(ListPosts::class)
            ->set('feed', true)
            ->assertSee($this->post->postable->title);
    }

    /** @test */
    public function will_delete_peer_posts()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $this->post->prepareForSyndication('saved'),
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $this->post->prepareForSyndication('deleted'),
            'event' => 'deleted',
        ]);

        $response->assertStatus(200);

        $this->actingAs($this->user);

        $this->assertCount(0, Post::syndicated()->get());

        Livewire::test(ListPosts::class)
            ->set('feed', true)
            ->assertDontSee($this->post->postable->title);
    }

    /** @test */
    public function will_accept_peer_comments()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $this->post->prepareForSyndication('saved'),
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.comment'), [
            'post' => json_encode($this->post->only(['uuid'])),
            'comment' =>  $this->comment->toJson(),
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $this->actingAs($this->user);

        $this->assertCount(1, Post::syndicated()->get());

        Livewire::test(ViewPost::class)
            ->call('open', Post::syndicated()->get()->first()->slug)
            ->assertSee($this->post->postable->title)
            ->assertSee($this->comment->comment);
    }

    /** @test */
    public function will_delete_peer_comments()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.post'), [
            'post' => $this->post->prepareForSyndication('saved'),
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.comment'), [
            'post' => json_encode($this->post->only(['uuid'])),
            'comment' =>  $this->comment->toJson(),
            'event' => 'saved',
        ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', route('peers.syndicate.comment'), [
            'post' => json_encode($this->post->only(['uuid'])),
            'comment' =>  json_encode($this->comment->only(['uuid'])),
            'event' => 'deleted',
        ]);

        $response->assertStatus(200);

        $this->actingAs($this->user);

        $this->assertCount(0, Comment::all());

        Livewire::test(ViewPost::class)
            ->call('open', Post::syndicated()->get()->first()->slug)
            ->assertDontSee($this->comment->comment);
    }
}