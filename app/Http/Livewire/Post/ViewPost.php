<?php

namespace App\Http\Livewire\Post;

use App\Post;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class ViewPost extends Component
{
    public $post;

    /** @var array */
    protected $listeners = ['postViewOpen' => 'open', 'postViewClose' => 'close'];

    public function open($id)
    {
        $this->post = Post::find($id);
    }

    public function close()
    {
        $this->post = null;
    }

    public function mount()
    {
        if (Route::currentRouteName() === 'post.view') {
            $this->post = Post::find(Route::current()->parameter('post'));
        }
    }

    public function render()
    {
        return view('livewire.post.view-post');
    }
}
