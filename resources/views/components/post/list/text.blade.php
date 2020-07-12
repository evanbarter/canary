<div x-on:click="view('{{ $post->slug }}')" class="flex flex-col p-4 h-64 rounded-lg shadow-lg text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900 dark-mode:bg-gray-800 dark-mode:hover:bg-gray-900 dark-mode:text-gray-200 dark-mode:hover:text-gray-400 cursor-pointer">
    <h2 class="h-full w-full font-light italic text-2xl leading-tight break-words">{{ $post->postable->title }}</h2>
    <div class="flex flex-row-reverse">
        <span class="flex-1 text-right text-xs" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
        @if ($post->syndicated)
        <span class="text-xs text-white shadow-md rounded-full py-1 px-3 bg-gradient-brand border border-red-400">{{ $post->sourceable->name }}</span>
        @endif
    </div>
</div>
