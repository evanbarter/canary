<form x-data="postForm()">
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="flex flex-col items-start">
            <div class="w-full mt-3 text-left sm:mt-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    {{ !$post ? __('New Post') : __('Edit Post') }}
                </h3>
                <div class="mt-3">
                    <x-post.visibility type="{{ __('Post') }}" visibility="{{ $visibility }}" />
                </div>
                <div class="mt-3">
                    <label for="pinned-post" class="text-sm">
                        <input id="pinned-post" class="border-gray-300 rounded text-orange-600" wire:model="pinned" type="checkbox" name="pinned"> {{ __('Pinned') }}
                    </label>
                    <span class="block text-xs">{{ __('Pinned Posts always appear at the top of your Post list.') }}</span>
                </div>
                <div class="mt-3">
                    <label for="title" class="block text-sm font-medium text-gray-700 leading-5">
                        {{ __('Title') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="title" id="title" name="title" type="text" required autofocus class="block w-full bg-white px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="text" class="block text-sm font-medium text-gray-700 leading-5">
                        {{ __('Post') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input x-ref="text" value="{{ $text }}" id="text" name="text" type="hidden" />
                        <div wire:ignore>
                            <trix-editor id="text-editor" input="text" class="block h-64 overflow-scroll resize-y w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('text') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"></trix-editor>
                        </div>
                        @error('text')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button @click.prevent="save" type="button" class="inline-flex justify-center w-full rounded-md border border-red-400 px-4 py-2 bg-gradient-brand text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                {{ !$post ? __('Post') : __('Edit') }}
            </button>
        </span>
        <span class="mt-3 flex flex-row-reverse flex-1 w-full sm:mt-0 sm:ml-3 sm:w-auto">
            <button @click="$store.postModal.open = null; window.livewire.emit('postEditorStopEditing')" type="button" class="inline-flex justify-center w-full sm:w-auto rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                {{ __('Cancel') }}
            </button>
        </span>
        @if ($post)
        <hr class="my-5 sm:hidden">
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button wire:click.prevent="delete" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-red-400 hover:bg-red-500 text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-red-300 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                {{ __('Delete') }}
            </button>
        </span>
        @endif
    </div>
</form>
@push('scripts')
<script>
    function postForm() {
        return {
            save() {
                window.livewire.emit('postEditorTextSave', {
                    text: this.$refs.text.value,
                })
            }
        }
    }
    window.livewire.on('postEditorTextReady', () => {
        const editor = document.getElementById('text-editor')
        const source = document.getElementById('text')
        editor.value = source.value;
    })
</script>
@endpush