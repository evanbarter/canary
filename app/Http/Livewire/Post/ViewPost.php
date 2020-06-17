<?php

namespace App\Http\Livewire\Post;

use App\Post;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class ViewPost extends Component
{
    /** @var \App\Post */
    public $post;

    /** @var bool */
    public $start_visible = false;

    /** @var array */
    protected $listeners = ['postViewOpen' => 'open', 'postViewClose' => 'close'];

    public function open($id)
    {
        $this->post = Post::find($id);
        if ($this->post->postable_type === 'text') {
            $this->emit('hideList');
        }
    }

    public function close()
    {
        $this->post = null;
        $this->start_visible = false;
    }

    public function mount()
    {
        if (Route::currentRouteName() === 'post.view') {
            $this->post = Post::findOrFail(Route::current()->parameter('post'));
            $this->start_visible = true;
        }
    }

    public function render()
    {
        return view('livewire.post.view-post');
    }
}
