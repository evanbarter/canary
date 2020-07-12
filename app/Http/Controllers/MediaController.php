<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Media $media)
    {
        // Medialibrary's toResponse sets this but for this app, caching images
        // for awhile is preferred.
        header('Cache-control: max-age=3600');
        return response()->download($media->getPath('optimized'), $media->file_name);
    }
}
