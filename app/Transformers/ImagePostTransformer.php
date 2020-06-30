<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class ImagePostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        $post->load('postable.media');
        $media = $post->postable->media->map(function ($image) {
            return $image->getUrl();
        });
        $post->images = $media;
        unset($post->postable->media);
        return $post->toArray();
    }
}
