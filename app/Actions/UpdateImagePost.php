<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Action;
use Carbon\Carbon;

class UpdateImagePost extends Action
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
        return [];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->post->postable->title = $this->titles;
        $this->post->postable->description = $this->descriptions;

        if (!$this->source || $this->source->is(auth()->user())) {
            $this->post->postable->clearMediaCollectionExcept('images', $this->images);
        } else {
            // Rebuild the collection instead of trying to diff it.
            $this->post->postable->clearMediaCollection('images');
            foreach ($this->images as $url) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->source->token,
                ])->get($url);

                $temporary_file = tempnam(sys_get_temp_dir(), 'peer_');
                file_put_contents($temporary_file, $response->body());

                $this->post->postable->addMedia($temporary_file)->toMediaCollection('images');
            }
        }

        $this->post->postable->save();

        if ($this->updated_at) {
            $this->post->timestamps = false;
            $this->post->updated_at = new Carbon($this->updated_at);
        }

        $this->post->visibility = $this->visibility ?? 1;
        $this->post->save();
    }
}
