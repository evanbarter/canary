<div class="mt-5">
    @if ($editing)
    <div id="comment-editor" wire:ignore>
        <input id="comment" type="hidden" name="comment">
        <trix-editor wire:model.debounce="comment" input="comment"></trix-editor>
    </div>
    <div class="flex flex-row-reverse">
        <button wire:click="save" type="button" class="mt-2 rounded-md border border-indigo-900 px-4 py-2 bg-gradient-alt text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            {{ $editing ? __('Comment') : __('Save') }}
        </button>
        <div class="flex-1"></div>
        <button wire:click="edit" class="mt-2 rounded-md border px-4 py-2 hover:bg-gray-100 text-base leading-6 font-medium shadow-sm focus:border-gray-300 focus:shadow-ouline-gray transition ease-in-out duration-150 sm:text-sm">{{ __('Cancel') }}</button>
    </div>
    @else
    <div class="p-3 text-sm relative bg-white shadow-lg rounded-lg">
        <span wire:click="edit" class="absolute mt-1 top-0 right-0">
            <svg class="h-6 w-6 cursor-pointer hover:text-red-400 transition-colors duration-150 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        </span>
        {!! $comment !!}
        <div class="flex flex-row-reverse mt-5">
            <span class="text-xs text-white shadow-md rounded-full py-1 px-3 bg-gradient-alt border border-indigo-900">
                {{ __('You') }}
            </span>
        </div>
    </div>
    @endif
</div>
