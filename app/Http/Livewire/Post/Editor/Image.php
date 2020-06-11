<?php

namespace App\Http\Livewire\Post\Editor;

use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;

    /** @var array */
    public $images = [];

    /** @var array */
    public $image_titles = [];

    /** @var array */
    public $image_descriptions = [];

    /** @var string */
    public $layout = 'gallery';

    /** @var string */
    public $gallery_title = '';

    public function remove(int $index)
    {
        unset($this->images[$index]);
    }

    public function save()
    {
        $this->validate([
            'images.*' => 'image|max:1024', // 1MB Max
        ]);

        $this->emit('postEditorSaved');
    }

    public function render()
    {
        return view('livewire.post.editor.image');
    }
}
