<div x-data="commentForm()" class="mt-5">
    @if ($editing)
    <div id="comment-editor">
        <input x-ref="comment" id="comment" type="hidden" name="comment" value="{{ $comment }}">
        <div wire:ignore>
            <trix-editor input="comment"></trix-editor>
        </div>
    </div>
    <div class="flex flex-row-reverse">
        <button @click.prevent="save" type="button" class="mt-2 rounded-md border border-indigo-800 px-4 py-2 bg-gradient-alt text-base leading-6 font-medium text-white shadow-md focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            {{ $editing ? __('Comment') : __('Save') }}
        </button>
        @if ($existing)
        <span class="flex-1 flex justify-end">
            <button wire:click="edit" class="mt-2 mr-2 rounded-md border px-4 py-2 hover:bg-gray-100 text-base leading-6 font-medium shadow-sm focus:border-gray-300 focus:shadow-ouline-gray transition ease-in-out duration-150 sm:text-sm">{{ __('Cancel') }}</button>
        </span>
        <button wire:click.prevent="delete" type="button" class="mt-2 justify-center rounded-md border border-red-400 px-4 py-2 bg-red-400 hover:bg-red-500 text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-red-300 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm dark-mode:bg-gray-500 dark-mode:text-white dark-mode:border-gray-800 dark-mode:hover:bg-gray-400 dark-mode:hover:text-gray-100">
                {{ __('Delete') }}
            </button>
        @endif
    </div>
    @else
    <x-post.comment :comment="$existing" />
    @endif
</div>
