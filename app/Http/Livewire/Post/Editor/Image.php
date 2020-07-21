<?php

namespace App\Http\Livewire\Post\Editor;

use App\Post;
use App\Actions\CreateImagePost;
use App\Actions\UpdateImagePost;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Image extends Component
{
    use WithFileUploads;

    /** @var int */
    public $visibility = 1;

    /** @var bool */
    public $pinned = false;

    /** @var array|\Illuminate\Support\Collection */
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
        'postEditorStopEditing' => 'stopEditing',
    ];

    public function startEditing($id)
    {
        $post = Post::find($id);

        $this->post = $post;
        $this->visibility = $post->visibility;
        $this->pinned = $post->pinned;
        $this->titles = $post->postable->title;
        $this->descriptions = $post->postable->description;
        $this->images = $post->postable->getMedia('images');

        $this->emit('postEditorReady');
    }

    public function stopEditing()
    {
        $this->reset();
    }

    public function updateOrder($sorted)
    {
        $updated = [];
        foreach ($sorted as $item) {
            list(, $key) = explode('-', $item['value']);
            $updated[] = $this->images[$key];
        }
        $this->images = $updated;
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
        $this->stopEditing();
    }

    public function render()
    {
        return view('livewire.post.editor.image');
    }

    private function update()
    {
        UpdateImagePost::dispatch([
            'post' => $this->post,
            'titles' => $this->titles,
            'descriptions' => $this->descriptions,
            'visibility' => $this->visibility,
            'pinned' => $this->pinned,
            'images' => $this->images,
        ]);

        return redirect()->route('post.view', $this->post);
    }

    private function create()
    {
        $images = collect($this->images)->map(function ($image) {
            return Storage::putFile('uploads', $image);
        });

        CreateImagePost::dispatch([
            'titles' => $this->titles,
            'descriptions' => $this->descriptions,
            'visibility' => $this->visibility,
            'pinned' => $this->pinned,
            'layout' => $this->layout,
            'source' => auth()->user(),
            'images' => $images,
        ]);
    }
}
