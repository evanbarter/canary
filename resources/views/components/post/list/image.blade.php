<div x-on:click="view({{ $post->id }})" class="relative h-64 rounded-lg shadow-xl text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 dark-mode:bg-gray-800 dark-mode:hover:bg-gray-900 dark-mode:text-gray-200 dark-mode:hover:text-gray-400 cursor-pointer">
    <img class="h-64 transition duration-150 ease-in-out transform hover:scale-105 w-full rounded-lg object-cover" src="{{ $post->postable->getFirstMediaUrl('images') }}">
    @if ($post->postable->getMedia('images')->count() > 1)
    <div class="absolute right-0 top-0 mr-2 mt-2 h-4 w-4 bg-gray-200 rounded-sm shadow"></div>
    <div class="absolute right-0 top-0 mr-4 mt-2 h-3 w-3 bg-gray-100 rounded-sm shadow-md z-10"></div>
    @endif
</div>
