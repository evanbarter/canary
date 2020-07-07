<?php

namespace App\Http\Livewire\Post;

use App\Post;
use App\Comment;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class CommentForm extends Component
{
    /** @var \App\Post */
    public $post;

    /** @var \App\Comment */
    public $existing;

    /** @var string */
    public $comment;

    /** @var bool */
    public $editing = true;

    public function mount($id)
    {
        $this->post = Post::find($id);
        $this->existing = Comment::whereHasMorph(
            'commentable',
            Post::class,
            function (Builder $query) use ($id) {
                $query->where('id', $id);
            }
        )->first();

        if ($this->existing) {
            $this->comment = $this->existing->comment;
            $this->editing = false;
        }
    }

    public function edit()
    {
        $this->editing = !$this->editing;
    }

    public function save()
    {
        if ($this->existing) {
            $this->existing->update(['comment' => $this->comment]);
        } else {
            $comment = new Comment;
            $comment->comment = $this->comment;
            $comment->sourceable()->associate(auth()->user());
            $comment->commentable()->associate($this->post);
            $comment->save();

            $this->existing = $comment;
        }

        $this->editing = false;
    }

    public function render()
    {
        return view('livewire.post.comment-form');
    }
}
