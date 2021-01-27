@if ($comment)
<div class="p-4 mb-3 text-sm relative bg-white dark:bg-gray-700 shadow-lg rounded-lg">
    {!! $comment->comment !!}
    <div class="flex flex-row-reverse mt-5">
        @if ($comment->syndicated)
        <a href="{{ $comment->sourceable->url }}" target="_blank">
        @endif
        <span class="text-xs text-white shadow-md rounded-full py-1 px-3 border {{ $comment->syndicated ? 'bg-gradient-brand border-red-400' : 'bg-gradient-alt border-indigo-900' }}">
            @if ($comment->syndicated)
            {{ $comment->sourceable->name }}
            @else
            {{ __('You') }}
            @endif
        </span>
        @if ($comment->syndicated)
        </a>
        @else
        <svg wire:click="edit" class="h-5 w-5 cursor-pointer hover:text-red-400 transition-colors duration-150 mt-1 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        @endif
    </div>
</div>
@endif
