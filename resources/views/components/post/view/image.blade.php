<div
    x-data="{ show: {{ $start_visible ? 'true' : 'false' }} }"
    x-show="show"
    x-init="setTimeout(() => { show = true }, 200)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform"
    x-transition:enter-end="opacity-100 transform"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform"
    x-transition:leave-end="opacity-0 transform"
    class="fixed z-40 inset-0 flex py-4 xl:py-16 xl:pt-8 justify-center">
    <div @click="show = false; setTimeout(() => {  $dispatch('post-close') }, 200)" class="fixed inset-0">
        <div class="absolute inset-0 bg-black dark-mode:bg-black opacity-75"></div>
    </div>
    <div class="flex flex-col max-w-full overflow-scroll sm:max-w-7xl z-50">
        <div x-data="gallery()" x-init="init({{ $post->postable->getMedia('images')->count() }})">
            <div class="flex">
                <h1 id="modal-headline" class="flex-1 pl-2 xl:pl-0 mb-4 font-thin italic text-xl sm:text-3xl leading-tight text-white dark-mode:text-gray-400">
                    @foreach ($post->postable->getMedia('images') as $image)
                    <span x-show="({{ $loop->index }} + 1) === active">{{ $post->postable->title[$loop->index] ?? ''}}</span>
                    @endforeach
                </h1>
                <div class="flex items-end ml-3 mb-3 text-gray-100 dark-mode:text-gray-200">
                    @can('update', $post)
                    <span @click="window.livewire.emit('postEditorImageEdit', {{ $post->id }}); $store.postModal.open = 'image'">
                        <svg class="h-8 w-8 cursor-pointer hover:text-red-400 transition-colors duration-150 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </span>
                    @endcan
                    <svg @click="show = false; setTimeout(() => { $dispatch('post-close') }, 200)" class="h-8 w-8 cursor-pointer hover:text-red-400 transition-colors duration-150" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex flex-col max-w-2/3 shadow-lg">
                <div class="relative">
                    @if ($post->postable->getMedia('images')->count() === 1)
                    <img class="object-cover" src="{{ $post->postable->getFirstMediaUrl('images') }}">
                    @else
                    @foreach ($post->postable->getMedia('images') as $image)
                    <img
                        x-show="({{ $loop->index }} + 1) === active"
                        {{-- x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 transform"
                        x-transition:enter-end="opacity-100 transform"
                        x-transition:leave="opacity-0" --}}
                        class="object-cover mx-auto" src="{{ $image->getUrl() }}">
                    @endforeach
                    <div class="absolute left-0 inset-y-0 w-1/3 cursor-pointer" @click="navigate(active === 1 ? count : active - 1)"></div>
                    <div class="absolute right-0 inset-y-0 w-1/3 cursor-pointer" @click="navigate(active === count ? 1 : active + 1)"></div>
                    <div class="absolute bottom-0 inset-x-y w-full flex justify-center pb-2">
                        @foreach ($post->postable->getMedia('images') as $image)
                        <span @click="navigate({{ $loop->index }} + 1)" :class="{ 'bg-white': ({{ $loop->index }} + 1) === active, 'bg-gray-300': ({{ $loop->index }} + 1) !== active }" class="inline-block mx-1 h-2 w-2 rounded cursor-pointer shadow"></span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="flex-grow flex flex-col-reverse w-full p-6 pt-2 shadow-inner bg-gray-50">
                    <div class="flex-1">
                        @foreach ($post->postable->getMedia('images') as $image)
                        @if (!empty($post->postable->description[$loop->index]))
                        <div class="text-sm" x-show="({{ $loop->index }} + 1) === active">{!! $post->postable->description[$loop->index] !!}<hr class="my-5" /></div>
                        @endif
                        @endforeach
                        @if ($post->syndicated)
                        <livewire:post.comment-form :id="$post->id" />
                        @elseif (auth()->user())
                        <div class="flex flex-row overflow-y-scroll">
                            @foreach($post->comments as $comment)
                            <div class="w-1/2 flex-none mr-3 md:mr-6">
                                <x-post.comment :comment="$comment" />
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-row-reverse pb-4">
                        <p class="flex-1 text-right text-xs mt-2" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</p>
                        @if ($post->syndicated)
                            <span class="text-xs text-white shadow-md rounded-full py-1 px-3 bg-gradient-brand border border-red-400">
                                <a href="{{ $post->sourceable->url }}" target="_blank">{{ $post->sourceable->name }}</a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
