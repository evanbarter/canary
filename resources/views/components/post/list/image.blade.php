<div x-on:click="view({{ $post->id }})" class="relative h-64 rounded-lg shadow-lg text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 dark-mode:bg-gray-800 dark-mode:hover:bg-gray-900 dark-mode:text-gray-200 dark-mode:hover:text-gray-400 cursor-pointer">
    <img class="h-64 transition duration-150 ease-in-out transform hover:scale-105 w-full rounded-lg object-cover" src="{{ $post->postable->getFirstMediaUrl('images') }}">
    @if ($post->postable->getMedia('images')->count() > 1)
    <div class="absolute right-0 top-0 mr-2 mt-2 h-4 w-4 bg-gray-500 rounded-sm shadow text-xs text-center text-gray-300">{{ $post->postable->getMedia('images')->count() }}</div>
    @endif
    @if ($post->syndicated)
    <span class="absolute left-0 bottom-0 ml-4 mb-4 text-xs text-white shadow-md rounded-full py-1 px-3 bg-gradient-brand border border-red-400">{{ $post->sourceable->name }}</span>
    @endif
</div>
