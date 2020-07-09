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
        @if ($existing)
        <button wire:click="edit" class="mt-2 rounded-md border px-4 py-2 hover:bg-gray-100 text-base leading-6 font-medium shadow-sm focus:border-gray-300 focus:shadow-ouline-gray transition ease-in-out duration-150 sm:text-sm">{{ __('Cancel') }}</button>
        @endif
    </div>
    @else
    <x-post.comment :comment="$existing" />
    @endif
</div>
