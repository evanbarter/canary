<?php

namespace App\Actions;

use App\Post;
use App\Text;
use Lorisleiva\Actions\Action;
use Carbon\Carbon;

class CreateTextPost extends Action
{
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the action.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'text' => 'required',
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {
        $text = Text::create($this->validated());

        $post = new Post;

        if ($this->created_at && $this->updated_at) {
            $post->timestamps = false;
            $post->created_at = new Carbon($this->created_at);
            $post->updated_at = new Carbon($this->updated_at);
        }

        $post->uuid = $this->uuid ?? null;
        $post->visibility = $this->visibility ?? 1;
        $post->pinned = $this->pinned ?? false;
        $post->sourceable()->associate($this->source);
        $post->postable()->associate($text);
        $post->save();
    }
}
