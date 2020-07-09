<div x-data="commentForm()" class="mt-5">
    @if ($editing)
    <div id="comment-editor">
        <input x-ref="comment" id="comment" type="hidden" name="comment">
        <div wire:ignore>
            <trix-editor wire:model.debounce="comment" input="comment"></trix-editor>
        </div>
    </div>
    <div class="flex flex-row-reverse">
        <button @click.prevent="save" type="button" class="mt-2 rounded-md border border-indigo-800 px-4 py-2 bg-gradient-alt text-base leading-6 font-medium text-white shadow-md focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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
@push('scripts')
<script>
    function commentForm() {
        return {
            save() {
                window.livewire.emit('commentSave', {
                    comment: this.$refs.comment.value
                })
            }
        }
    }
</script>
@endpush