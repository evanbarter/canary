<?php

namespace Tests\Feature\Post;

use App\User;
use App\Post;
use App\Text as TextPost;
use App\Http\Livewire\Post\Editor\Text;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TextPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function title_is_required()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Text::class)
            ->set('title', '')
            ->call('save')
            ->assertHasErrors(['title' => 'required']);
    }

    /** @test */
    public function text_is_required()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Text::class)
            ->call('save', ['text' => ''])
            ->assertHasErrors(['text' => 'required']);
    }

    /** @test */
    public function can_create_text_post()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Text::class)
            ->set('title', 'foo')
            ->call('save', ['text' => 'bar']);

        $this->assertTrue(TextPost::whereTitle('foo')->exists());
    }

    /** @test */
    public function create_text_post_emits_event()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Text::class)
            ->set('title', 'foo')
            ->call('save', ['text' => 'bar'])
            ->assertEmitted('postEditorSaved');
    }
}
