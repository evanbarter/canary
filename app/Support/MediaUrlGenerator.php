<?php

namespace App\Support;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class MediaUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $url = route('media.view', $this->media);

        $url = $this->versionUrl($url);

        return $url;
    }
}
