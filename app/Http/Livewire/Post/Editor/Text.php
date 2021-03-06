<?php

namespace App\Http\Livewire\Post\Editor;

use App\Post;
use App\Actions\CreateTextPost;
use App\Actions\UpdateTextPost;
use Illuminate\Support\Arr;
use Livewire\Component;

class Text extends Component
{
    /** @var int */
    public $visibility = 1;

    /** @var bool */
    public $pinned = false;

    /** @var string */
    public $title = '';

    /** @var string */
    public $text = '';

    /** @var bool|\App\Post */
    public $post = false;

    /** @var array */
    protected $listeners = [
        'postEditorTextSave' => 'save',
        'postEditorTextEdit' => 'startEditing',
        'postEditorStopEditing' => 'stopEditing',
    ];

    public function startEditing($id)
    {
        $post = Post::find($id);

        $this->post = $post;
        $this->visibility = $post->visibility;
        $this->pinned = $post->pinned;
        $this->title = $post->postable->title;
        $this->text = $post->postable->text;

        $this->emit('postEditorTextReady');
    }

    public function stopEditing()
    {
        $this->reset();
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

    public function save($data)
    {
        $this->text = Arr::get($data, 'text');
        $this->post ? $this->update() : $this->create();

        $this->emit('postEditorSaved');
        $this->stopEditing();
    }

    private function create()
    {
        CreateTextPost::dispatch([
            'source' => auth()->user(),
            'title' => $this->title,
            'text' => $this->text,
            'visibility' => $this->visibility,
            'pinned' => $this->pinned,
        ]);
    }

    private function update()
    {
        UpdateTextPost::dispatch([
            'post' => $this->post,
            'title' => $this->title,
            'text' => $this->text,
            'visibility' => $this->visibility,
            'pinned' => $this->pinned,
        ]);

        return redirect()->route('post.view', $this->post);
    }

    public function render()
    {
        return view('livewire.post.editor.text');
    }
}
