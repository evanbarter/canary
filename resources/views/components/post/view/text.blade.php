<div
    x-data="{ show: {{ $start_visible ? 'true' : 'false' }} }"
    x-show="show"
    x-init="setTimeout(() => { show = true }, 200)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="absolute inset-0 py-12 pb-16 flex justify-center">
    <div class="flex flex-col w-4/5 sm:max-w-4xl">
        <div class="flex">
            <h1 id="modal-headline" class="flex-1 mb-4 font-hairline italic text-xl sm:text-3xl leading-tight text-gray-900 dark-mode:text-gray-400">{{ is_array($post->postable->title) ? ($post->postable->title[0] ?? '') : $post->postable->title }}</h1>
            <div class="flex items-end ml-6 mb-4 text-gray-700 dark-mode:text-gray-200">
                @can('update', $post)
                <span @click="window.livewire.emit('postEditorTextEdit', {{ $post->id }}); $store.postModal.open = 'text'">
                    <svg class="h-8 w-8 cursor-pointer hover:text-gray-800 transition-colors duration-200 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </span>
                @endcan
                <svg @click="show = false; setTimeout(() => { $dispatch('post-close') }, 200)" class="h-8 w-8 cursor-pointer hover:text-gray-900 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="h-full overflow-y-scroll dark-mode:border dark-mode:bg-gray-900 dark-mode:border-gray-800">
            <div class="text-sm pb-8 sm:text-base dark-mode:text-gray-200">
                <div class="flex mb-6">
                    @if ($post->syndicated)
                    <span class="text-xs text-white shadow-md rounded-full py-1 px-3 bg-gradient-brand border border-red-400 mr-3">
                        <a href="{{ $post->sourceable->url }}" target="_blank">{{ $post->sourceable->name }}</a>
                    </span>
                    @endif
                    <p class="text-xs pt-1" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</p>
                </div>
                {!! $post->postable->text !!}
            </div>
        </div>
    </div>
</div>
