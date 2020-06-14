<?php

namespace App\Http\Livewire\Post;

use App\Post;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class ListPosts extends Component
{
    /** @var array */
    public $posts;

    /** @var bool */
    public $show = true;

    /** @var array */
    protected $listeners = ['postEditorSaved' => '$refresh'];

    public function mount()
    {
        $this->hydrate();
        if (Route::currentRouteName() === 'post.view') {
            $post = Post::find(Route::current()->parameter('post'));
            if ($post->postable_type === 'text') {
                $this->show = false;
            }
        }
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
