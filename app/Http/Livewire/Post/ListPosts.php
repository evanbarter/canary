<?php

namespace App\Http\Livewire\Post;

use App\Post;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class ListPosts extends Component
{
    /** @var array */
    public $posts;

    /** @var array */
    public $pinned;

    /** @var bool */
    public $show = true;

    /** @var bool */
    public $feed = false;

    /** @var array */
    protected $listeners = ['postEditorSaved' => '$refresh'];

    public function mount()
    {
        if (in_array(Route::currentRouteName(), ['feed', 'feed.post.view'])) {
            $this->feed = true;
        }
        if (in_array(Route::currentRouteName(), ['post.view', 'feed.post.view'])) {
            $post = Post::where('slug', Route::current()->parameter('post'))->firstOrFail();
            if ($post->postable_type === 'text') {
                $this->show = false;
            }
        }
        $this->hydrate();
    }

    public function hydrate()
    {
        if ($this->feed) {
            $this->posts = Post::syndicated()->orderBy('created_at', 'desc')->get();
        } else {
            $posts = Post::local()->orderBy('created_at', 'desc');

            if (!auth()->user()) {
                $posts->public();
            }

            $this->pinned = (clone $posts)->where('pinned', true)->get();
            $this->posts = $posts->where('pinned', false)->get();
        }
    }

    public function render()
    {
        return view('livewire.post.list-posts');
    }
}
