<?php

namespace App\Http\Livewire\Post\Editor;

use App\Post;
use App\Text as TextPost;
use Illuminate\Support\Arr;
use Livewire\Component;

class Text extends Component
{
    /** @var string */
    public $title = '';

    /** @var string */
    public $text = '';

    /** @var array */
    protected $listeners = ['postEditorTextSave' => 'save'];

    public function save($data)
    {
        $this->text = Arr::get($data, 'text');

        $this->validate([
            'title' => 'required',
            'text' => 'required',
        ]);

        $text = TextPost::create(['text' => $this->text]);
        $post = new Post;
        $post->title = $this->title;
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
