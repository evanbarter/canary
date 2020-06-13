<?php

namespace App\Http\Livewire\Post;

use App\Post;
use Livewire\Component;

class ListPosts extends Component
{
    /** @var array */
    public $posts;

    /** @var array */
    protected $listeners = ['postEditorSaved' => '$refresh'];

    public function mount()
    {
        $this->hydrate();
    }

    public function hydrate()
    {
        $this->posts = Post::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.post.list-posts');
    }
}
