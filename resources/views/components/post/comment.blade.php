@if ($comment)
<div class="p-3 mb-3 text-sm relative bg-white shadow-lg rounded-lg">
    @if (!$comment->syndicated)
    <span wire:click="edit" class="absolute mt-1 top-0 right-0">
        <svg class="h-5 w-5 cursor-pointer hover:text-red-400 transition-colors duration-150 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
    </span>
    @endif
    {!! $comment->comment !!}
    <div class="flex flex-row-reverse mt-5">
        <span class="text-xs text-white shadow-md rounded-full py-1 px-3 border {{ $comment->syndicated ? 'bg-gradient-brand border-red-400' : 'bg-gradient-alt border-indigo-900' }}">
            {{ $comment->syndicated ? $comment->sourceable->name : __('You') }}
        </span>
    </div>
</div>
@endif
