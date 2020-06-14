<div x-on:click="view({{ $post->id }})" class="flex flex-col p-4 h-64 rounded-lg shadow-xl text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 dark-mode:bg-gray-800 dark-mode:hover:bg-gray-900 dark-mode:text-gray-200 dark-mode:hover:text-gray-400 cursor-pointer">
    <h2 class="h-full w-full font-light italic text-2xl leading-tight break-words">{{ $post->postable->title }}</h2>
    <span class="text-right text-xs" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
</div>
