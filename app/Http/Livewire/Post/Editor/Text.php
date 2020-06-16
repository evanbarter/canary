<?php

namespace App\Http\Livewire\Post\Editor;

use App\Post;
use App\Text as TextPost;
use Illuminate\Support\Arr;
use Livewire\Component;

class Text extends Component
{
    /** @var int */
    public $visibility = -1;

    /** @var string */
    public $title = '';

    /** @var string */
    public $text = '';

    /** @var array */
    protected $listeners = ['postEditorTextSave' => 'save'];

    public function save($data)
    {
        $this->text = Arr::get($data, 'text');

        $text = TextPost::create($this->validate([
            'title' => 'required',
            'text' => 'required',
        ]));

        $post = new Post;
        $post->visibility = $this->visibility;
        $post->user()->associate(auth()->user());
        $post->postable()->associate($text);
        $post->save();

        $this->emit('postEditorSaved');
    }

    public function render()
    {
        return view('livewire.post.editor.text');
    }
}
