<?php

namespace App\Http\Livewire\Post\Editor;

use App\Post;
use App\Image as ImagePost;
use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;

    /** @var int */
    public $visibility = -1;

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
                $post = ImagePost::create([
                    'title' => [$this->titles[$index] ?? ''],
                    'description' => [$this->descriptions[$index] ?? ''],
                ]);
                $post->addMediaFromUrl($image->temporaryUrl())->toMediaCollection('images');

                $this->createPost($post);
            }
        } else {
            $post = ImagePost::create([
                'title' => $this->titles,
                'description' => $this->descriptions,
            ]);
            foreach ($this->images as $image) {
                $post->addMediaFromUrl($image->temporaryUrl())->toMediaCollection('images');
            }

            $this->createPost($post);
        }

        $this->emit('postEditorSaved');
    }

    public function render()
    {
        return view('livewire.post.editor.image');
    }

    private function createPost($image)
    {
        $post = new Post;
        $post->user()->associate(auth()->user());
        $post->postable()->associate($image);
        $post->save();
    }
}
