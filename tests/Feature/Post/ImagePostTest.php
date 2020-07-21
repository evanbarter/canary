<?php

namespace Tests\Feature\Post;

use App\User;
use App\Post;
use App\Image as ImagePost;
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

    /** @test */
    public function can_create_individual_image_posts()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake();

        $images = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.jpg'),
        ];

        Livewire::test(Image::class)
            ->set('images', $images)
            ->set('layout', 'individual')
            ->call('save');

        $this->assertTrue(Post::all()->count() === 2);
    }

    /** @test */
    public function title_is_optional()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake();

        Livewire::test(Image::class)
            ->set('images', UploadedFile::fake()->image('test1.jpg'))
            ->set('titles', [])
            ->call('save');

        Livewire::test(Image::class)
            ->set('images', UploadedFile::fake()->image('test2.jpg'))
            ->set('titles', ['Title'])
            ->call('save');

        $this->assertTrue(ImagePost::find(1)->title[0] === '');
        $this->assertTrue(ImagePost::find(2)->title[0] === 'Title');
    }

    /** @test */
    public function description_is_optional()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake();

        Livewire::test(Image::class)
            ->set('images', UploadedFile::fake()->image('test1.jpg'))
            ->set('descriptions', [])
            ->call('save');

        Livewire::test(Image::class)
            ->set('images', UploadedFile::fake()->image('test2.jpg'))
            ->set('descriptions', ['Desc'])
            ->call('save');

        $this->assertTrue(ImagePost::find(1)->description[0] === '');
        $this->assertTrue(ImagePost::find(2)->description[0] === 'Desc');
    }

    /** @test */
    public function image_can_be_removed()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake();

        $images = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.jpg'),
        ];

        $component = Livewire::test(Image::class)
            ->set('images', $images);

        $component->call('remove', 1);
        $files = $component->viewData('images');

        $this->assertCount(1, $files);
        $this->assertTrue($files[0]->getClientOriginalName() === 'test1.jpg');
    }

    /** @test */
    public function emits_events()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake();

        $images = [
            UploadedFile::fake()->image('test1.jpg'),
        ];

        $component = Livewire::test(Image::class);
        $component->set('images', $images)
            ->call('save')
            ->assertEmitted('postEditorSaved');

        $component->call('startEditing', 1)
            ->assertEmitted('postEditorReady');
    }
}
