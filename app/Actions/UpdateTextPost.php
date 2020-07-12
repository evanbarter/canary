<?php

namespace App\Actions;

use Lorisleiva\Actions\Action;
use Carbon\Carbon;

class UpdateTextPost extends Action
{
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
        $this->post->postable->title = $this->title;
        $this->post->postable->text = $this->text;
        $this->post->postable->save();

        if ($this->updated_at) {
            $this->post->timestamps = false;
            $this->post->updated_at = new Carbon($this->updated_at);
        }

        $this->post->visibility = $this->visibility ?? 1;
        $this->post->pinned = $this->pinned ?? false;
        $this->post->save();
    }
}
