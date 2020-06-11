<form>
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark-mode:bg-gray-900 dark-mode:text-white">
        <div class="flex flex-col items-start">
            <div class="w-full mt-3 text-left sm:mt-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark-mode:text-gray-200" id="modal-headline">
                    {{ __('New Photo or Image') }}
                </h3>
                <div class="mt-3">
                    <x-post.visibility />
                </div>
                <div class="mt-3">
                    <label for="files" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
                        {{ __('Files') }}
                    </label>
                    <input type="file" wire:model="images" multiple />
                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if (count($images) > 1)
                <div class="mt-3">
                    <label for="layout" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
                        {{ __('Layout') }}
                    </label>
                    <div id="layout" x-data="{ layout: '{{ $layout }}' }" class="grid grid-cols-2 gap-1 sm:gap-2">
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': layout === 'gallery' }" @click="layout = 'gallery'" for="layout-gallery" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input wire:model="layout" id="layout-gallery" class="form-radio text-indigo-600" type="radio" name="layout" value="gallery" /></div>
                            <div class="flex flex-col w-full">
                                <span class="font-bold">{{ __('Gallery') }}</span>
                                <div class="flex justify-center mt-1">
                                    <div class="w-1/3 h-12 relative">
                                        <div class="absolute inset-x-0 -ml-8 mb-1 bottom-0 h-10 w-10 bg-gray-100 border border-gray-400 shadow"></div>
                                        <div class="absolute inset-x-0 bottom-0 h-12 w-12 bg-gray-200 border border-gray-400 shadow z-10"></div>
                                        <div class="absolute inset-x-0 ml-10 mb-1 bottom-0 h-10 w-10 bg-gray-100 border border-gray-400 shadow"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': layout === 'individual' }" @click="layout = 'individual'" for="layout-individual" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
                            <div class="mr-2"><input wire:model="layout" id="layout-individual" class="form-radio text-indigo-600" type="radio" name="layout" value="individual" /></div>
                            <div class="flex flex-col w-full">
                                <span class="font-bold">{{ __('Individual') }}</span>
                                <div class="flex justify-center mt-1">
                                    <div class="grid grid-cols-3 gap-1 h-12">
                                        <div class="w-12 bg-gray-200 border border-gray-400 shadow"></div>
                                        <div class="w-12 bg-gray-100 border border-gray-400 shadow"></div>
                                        <div class="w-12 bg-gray-200 border border-gray-400 shadow"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                @if ($layout === 'gallery')
                <div class="mt-3">
                    <label for="gallery_title" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
                        {{ __('Gallery Title') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="gallery_title" id="gallery_title" name="gallery_title" type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('gallery_title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                    </div>
                    @error('gallery_title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif
                @endif
                @if ($images)
                <div class="mt-3 grid grid-cols-3 gap-2">
                    @foreach ($images as $index => $image)
                    <div class="col-span-1 relative overflow-visible">
                        <div wire:click="remove({{ $index }})" class="absolute top-0 right-0 -mr-3 -mt-3 p-1 h-8 w-8 z-10 bg-black text-white shadow rounded-full cursor-pointer hover:bg-gray-700">
                            <svg class="h-full w-full" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <img class="object-cover" src="{{ $image->temporaryUrl() }}">
                    </div>
                    <div class="col-span-2">
                        {{-- TODO: Image title/description fields --}}
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark-mode:bg-gray-700">
        <span wire:click="save" class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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
