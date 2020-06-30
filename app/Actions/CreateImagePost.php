<?php

namespace App\Actions;

use App\Post;
use App\Image;
use Lorisleiva\Actions\Action;
use Carbon\Carbon;

class CreateImagePost extends Action
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
        return [];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->images) === 1 || $this->layout === 'individual') {
            foreach ($this->images as $index => $image) {
                $post = Image::create([
                    'title' => [$this->titles[$index] ?? ''],
                    'description' => [$this->descriptions[$index] ?? ''],
                ]);
                $post->addMediaFromUrl($image)->toMediaCollection('images');

                $this->createPost($post);
            }
        } else {
            $post = Image::create([
                'title' => $this->titles ?? [],
                'description' => $this->descriptions ?? [],
            ]);
            foreach ($this->images as $image) {
                $post->addMediaFromUrl($image)->toMediaCollection('images');
            }

            $this->createPost($post);
        }
    }

    private function createPost($image)
    {
        $post = new Post;

        if ($this->created_at && $this->updated_at) {
            $post->timestamps = false;
            $post->created_at = new Carbon($this->created_at);
            $post->updated_at = new Carbon($this->updated_at);
        }

        $post->visibility = $this->visibility ?? 1;
        $post->sourceable()->associate($this->source ?? auth()->user());
        $post->postable()->associate($image);
        $post->save();
    }
}
