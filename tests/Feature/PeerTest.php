<?php

namespace Tests\Feature;

use App\User;
use App\Peer;
use App\Jobs\PeerHandshake;
use App\Http\Livewire\Settings;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PeerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function url_is_required()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Settings::class)
            ->set('peerAddURL', '')
            ->call('addPeer')
            ->assertHasErrors(['peerAddURL' => 'required']);
    }

    /** @test */
    public function url_is_valid()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Settings::class)
            ->set('peerAddURL', 'foo')
            ->call('addPeer')
            ->assertHasErrors(['peerAddURL' => 'url']);
    }

    /** @test */
    public function can_create_peer()
    {
        $this->actingAs(factory(User::class)->create());

        // Disable events as an observer will fire a HTTP request on the
        // created event.
        Peer::unsetEventDispatcher();

        Livewire::test(Settings::class)
            ->set('peerAddURL', 'http://foo.com')
            ->call('addPeer');

        $this->assertCount(1, Peer::all());
    }

    /** @test */
    public function create_peer_fires_request()
    {
        $this->actingAs(factory(User::class)->create());

        $this->expectsJobs(PeerHandshake::class);

        Livewire::test(Settings::class)
            ->set('peerAddURL', 'http://example.com')
            ->call('addPeer');
    }

    /** @test */
    public function confirm_peer_fires_request()
    {
        $this->actingAs(factory(User::class)->create());

        $this->expectsJobs(PeerHandshake::class);

        $peer = factory(Peer::class)->create();
        $response = $this->get(route('peers.confirm', $peer));

        $response->assertRedirect(route('settings'));
    }
}
