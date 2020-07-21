<?php

namespace Tests\Feature\Post;

use App\User;
use App\Post;
use App\Http\Livewire\Post\Editor\Image;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImagePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function images_are_required()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(Image::class)
            ->call('save', ['images' => []])
            ->assertHasErrors(['images' => 'required']);
    }

    /** @test */
    public function can_create_gallery_image_post()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake();

        $images = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.jpg'),
        ];

        Livewire::test(Image::class)
            ->set('images', $images)
            ->set('layout', 'gallery')
            ->call('save');

        $this->assertTrue(Post::all()->count() === 1);
    }
}
