<form id="image-editor">
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-11/12 overflow-scroll">
        <div class="flex flex-col items-start">
            <div class="w-full mt-3 text-left sm:mt-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    {{ !$post ? __('New Post') : __('Edit Post') }}
                </h3>
                <div class="mt-3">
                    <x-post.visibility type="{{ __('Image') }}" visibility="{{ $visibility }}" />
                </div>
                @if (!$images)
                <div class="mt-3">
                    <label for="files" class="hidden text-sm font-medium text-gray-700 leading-5">
                        {{ __('Files') }}
                    </label>
                    <input x-ref="images" class="hidden" type="file" wire:model="images" multiple />
                    <button @click.prevent="$refs.images.click()" class="block w-full p-2 text-sm text-gray-700 font-bold rounded shadow border hover:bg-gray-50 active:bg-gray-100 focus:outline-none">
                        {{ __('Click to Select Images') }}
                    </button>
                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif
                @if (count($images) > 1 && !$post)
                <div class="mt-3">
                    <label for="layout" class="block text-sm font-medium text-gray-700 leading-5">
                        {{ __('Layout') }}
                    </label>
                    <div id="layout" x-data="{ layout: '{{ $layout }}' }" class="grid grid-cols-2 gap-1 sm:gap-2">
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': layout === 'gallery' }" @click="layout = 'gallery'" for="layout-gallery" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input wire:model="layout" id="layout-gallery" class="form-radio text-indigo-600" type="radio" name="layout" value="gallery" /></div>
                            <div class="flex flex-col w-full">
                                <span class="font-bold">{{ __('Gallery') }}</span>
                                <div class="flex justify-center mt-4 sm:mt-1">
                                    <div class="w-1/3 h-6 sm:h-12 relative">
                                        <div class="absolute inset-x-0 -ml-3 sm:-ml-8 mb-1 bottom-0 h-4 w-4 sm:h-10 sm:w-10 bg-gray-100 border border-gray-400 shadow"></div>
                                        <div class="absolute inset-x-0 bottom-0 h-6 w-6 sm:h-12 sm:w-12 bg-gray-200 border border-gray-400 shadow z-10"></div>
                                        <div class="absolute inset-x-0 ml-5 sm:ml-10 mb-1 bottom-0 h-4 w-4 sm:h-10 sm:w-10 bg-gray-100 border border-gray-400 shadow"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': layout === 'individual' }" @click="layout = 'individual'" for="layout-individual" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input wire:model="layout" id="layout-individual" class="form-radio text-indigo-600" type="radio" name="layout" value="individual" /></div>
                            <div class="flex flex-col w-full">
                                <span class="font-bold">{{ __('Individual') }}</span>
                                <div class="flex justify-center mt-4 sm:mt-1">
                                    <div class="grid grid-cols-3 gap-1 h-6 sm:h-12">
                                        <div class="w-6 sm:w-12 bg-gray-200 border border-gray-400 shadow"></div>
                                        <div class="w-6 sm:w-12 bg-gray-100 border border-gray-400 shadow"></div>
                                        <div class="w-6 sm:w-12 bg-gray-200 border border-gray-400 shadow"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                @endif
                @if ($images)
                @if ($layout === 'gallery' || count($images) === 1)
                <div class="mt-3">
                    <label for="pinned-post" class="text-sm">
                        <input id="pinned-post" class="border-gray-300 rounded text-orange-600" wire:model="pinned" type="checkbox" name="pinned"> {{ __('Pinned') }}
                    </label>
                    <span class="block text-xs">Pinned Posts always appear at the top of your Post list.</span>
                </div>
                @endif
                <div wire:sortable="updateOrder" class="mt-6">
                    @foreach ($images as $image)
                    <div wire:sortable.item="image-{{ $loop->index }}" wire:key="image-{{ $loop->index }}" class="flex mb-5">
                        <div wire:sortable.handle class="w-1/3 relative overflow-visible">
                            @if (!$post || ($post && count($images) > 1 && $layout === 'gallery'))
                            <div wire:click="remove({{ $loop->index }})" class="absolute top-0 right-0 -mr-2 -mt-2 p-1 h-6 w-6 z-10 bg-black text-white shadow rounded-full cursor-pointer hover:bg-gray-700">
                                <svg class="h-full w-full" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            @endif
                            <img class="object-cover rounded @error('images.' . $loop->index) border-4 border-red-300 @enderror" src="{{ !$post ? $image->temporaryUrl() : $image->getUrl() }}">
                        </div>
                        <div class="w-2/3 pl-5">
                            <div>
                                <label for="title-{{ $loop->index }}" class="block text-sm font-medium text-gray-700 leading-5">
                                    {{ __('Title') }}
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input wire:model.lazy="titles.{{ $loop->index }}" id="title-{{ $loop->index }}" type="text" required class="appearance-none bg-white block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('titles.' . $loop->index) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                                </div>
                                @error('titles.' . $loop->index)
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div wire:ignore class="mt-3">
                                <label for="description-{{ $loop->index }}" class="block text-sm font-medium text-gray-700 leading-5">
                                    {{ __('Description') }}
                                </label>
                                <input id="description-{{ $loop->index }}" type="hidden" name="content">
                                <trix-editor class="border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" wire:model.debounce="descriptions.{{ $loop->index }}" input="description-{{ $loop->index }}"></trix-editor>
                            </div>
                            @error('images.' . $loop->index)
                                <p class="mt-2 text-sm text-red-600">{{ str_replace('images.' . $loop->index, __('Image'), $message) }}</p>
                            @enderror
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <span wire:click="save" class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-gradient-brand text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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
