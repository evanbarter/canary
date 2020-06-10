<form x-data="postForm()">
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark-mode:bg-gray-900 dark-mode:text-white">
        <div class="flex flex-col items-start">
            <div class="w-full mt-3 text-left sm:mt-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark-mode:text-gray-200" id="modal-headline">
                    {{ __('New Post') }}
                </h3>
                <div class="mt-3">
                    <label for="visibility" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
                        {{ __('Visibility') }}
                    </label>
                    <div x-data="{ selected: 1 }" class="grid grid-cols-3 gap-1 sm:gap-2">
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': selected === 1 }" @click="selected = 1" for="visibility-1" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input id="visibility-1" class="form-radio text-indigo-600" type="radio" name="visibility" value="1" checked="checked" /></div>
                            <div class="flex flex-col">
                                <span class="font-bold">{{ __('Public') }}</span>
                                <span class="text-xs sm:text-sm">{{ __('Anyone will be able to read this Post.') }}</span>
                            </div>
                        </label>
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': selected === 0 }" @click="selected = 0" for="visibility-0" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input id="visibility-0" class="form-radio text-indigo-600" type="radio" name="visibility" value="0" /></div>
                            <div class="flex flex-col">
                                <span class="font-bold">{{ __('Followers') }}</span>
                                <span class="text-xs sm:text-sm">{{ __('Only followers may read this Post.') }}</span>
                            </div>
                        </label>
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': selected === -1 }" @click="selected = -1" for="visibility--1" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input id="visibility--1" class="form-radio text-indigo-600" type="radio" name="visibility" value="-1" /></div>
                            <div class="flex flex-col">
                                <span class="font-bold">{{ __('Private') }}</span>
                                <span class="text-xs sm:text-sm">{{ __('This Post is only visible to you.') }}</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="title" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
                        {{ __('Title') }}
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="title" id="title" name="title" type="title" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>

                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="text" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
                        {{ __('Post') }}
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input x-ref="text" value="{{ $text }}" id="text" name="text" type="hidden" />
                        <div wire:ignore>
                            <trix-editor input="text" class="appearance-none block h-64 overflow-scroll resize-y w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('text') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"></trix-editor>
                        </div>
                        @error('text')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark-mode:bg-gray-700">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button @click.prevent="save" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                {{ __('Post') }}
            </button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button @click="$store.postModal.open = null" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5 dark-mode:bg-gray-500 dark-mode:text-white dark-mode:border-gray-800 dark-mode:hover:bg-gray-400 dark-mode:hover:text-gray-100">
                {{ __('Cancel') }}
            </button>
        </span>
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
                window.livewire.on('postEditorSaved', () => {
                    Spruce.store('postModal').open = null
                })
            }
        }
    }
</script>
@endpush