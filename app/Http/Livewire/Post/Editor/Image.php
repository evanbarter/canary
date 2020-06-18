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
    public $visibility = 1;

    /** @var array */
    public $images = [];

    /** @var array */
    public $titles = [];

    /** @var array */
    public $descriptions = [];

    /** @var string */
    public $layout = 'gallery';

    /** @var bool|\App\Post */
    public $post = false;

    protected $listeners = [
        'postEditorImageEdit' => 'startEditing',
    ];

    public function startEditing($id)
    {
        $post = Post::find($id);

        $this->post = $post;
        $this->visibility = $post->visibility;
        $this->titles = $post->postable->title;
        $this->descriptions = $post->postable->description;
        $this->images = $post->postable->getMedia('images');

        $this->emit('postEditorReady');
    }

    public function remove(int $index)
    {
        if (!$this->post) {
            array_splice($this->images, $index, 1);
        } else {
            $this->images->splice($index, 1);
        }
        array_splice($this->titles, $index, 1);
        array_splice($this->descriptions, $index, 1);
    }

    public function delete()
    {
        if (!$this->post) {
            abort(403);
        }

        $this->post->postable->delete();
        $this->post->delete();

        return redirect()->route('home');
    }

    public function save()
    {
        $this->validate([
            'images.*' => 'image|max:532480', // 5 MB Max
        ]);

        $this->post ? $this->update() : $this->create();


        $this->emit('postEditorSaved');
    }

    public function render()
    {
        return view('livewire.post.editor.image');
    }

    private function update()
    {
        $this->post->postable->title = $this->titles;
        $this->post->postable->description = $this->descriptions;
        $this->post->postable->clearMediaCollectionExcept('images', $this->images);
        $this->post->postable->save();
        $this->post->visibility = $this->visibility;
        $this->post->save();

        return redirect()->route('post.view', $this->post);
    }

    private function create()
    {
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
    }

    private function createPost($image)
    {
        $post = new Post;
        $post->visibility = $this->visibility;
        $post->user()->associate(auth()->user());
        $post->postable()->associate($image);
        $post->save();
    }
}
