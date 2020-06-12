<div x-on:click="view({{ $post->id }})" class="h-64 rounded-lg shadow-xl text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 dark-mode:bg-gray-800 dark-mode:hover:bg-gray-900 dark-mode:text-gray-200 dark-mode:hover:text-gray-400 cursor-pointer">
    <img class="h-64 w-full rounded-lg object-cover" src="{{ $post->postable->getFirstMediaUrl('images') }}">
    {{-- <div class="flex flex-col p-4">
        <h2 class="h-full w-full font-serif font-bold italic text-2xl leading-tight break-words">{{ $post->postable->title }}</h2>
        <span class="text-right text-xs" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
    </div> --}}
</div>