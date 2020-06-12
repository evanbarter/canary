<?php

namespace App\Http\Livewire\Post\Editor;

use App\Post;
use App\Image as ImagePost;
use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;

    /** @var array */
    public $images = [];

    /** @var array */
    public $titles = [];

    /** @var array */
    public $descriptions = [];

    /** @var string */
    public $layout = 'gallery';

    public function remove(int $index)
    {
        array_splice($this->images, $index, 1);
    }

    public function save()
    {
        $this->validate([
            'images.*' => 'image|max:532480', // 5 MB Max
        ]);

        if (count($this->images) === 1 || $this->layout === 'individual') {
            foreach ($this->images as $index => $image) {
                $image_post = ImagePost::create(['title' => $this->titles[$index]]);
                $image_post->addMediaFromUrl($image->temporaryUrl())->toMediaCollection('images');

                $post = new Post;
                $post->user()->associate(auth()->user());
                $post->postable()->associate($image_post);
                $post->save();
            }
        }

        $this->emit('postEditorSaved');
    }

    public function render()
    {
        return view('livewire.post.editor.image');
    }
}
