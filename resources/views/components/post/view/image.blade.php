<div
    x-data="{ show: {{ $start_visible ? 'true' : 'false' }} }"
    x-show="show"
    x-init="setTimeout(() => { show = true }, 200)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform"
    x-transition:enter-end="opacity-100 transform"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform"
    x-transition:leave-end="opacity-0 transform"
    class="fixed z-50 inset-0 flex pt-16 justify-center">
    <div @click="show = false; $dispatch('post-close')" class="fixed inset-0">
        <div class="absolute inset-0 bg-black dark-mode:bg-black opacity-50"></div>
    </div>
    <div class="flex flex-col max-h-11/12 w-full sm:max-w-4xl z-50">
        <div x-data="gallery()" x-init="init({{ $post->postable->getMedia('images')->count() }})">
            <div class="flex">
                <h1 id="modal-headline" class="flex-1 mb-4 font-hairline italic text-xl sm:text-3xl leading-tight text-white dark-mode:text-gray-400">
                    @foreach ($post->postable->getMedia('images') as $image)
                    <span x-show="({{ $loop->index }} + 1) === active">{{ $post->postable->title[$loop->index] }}</span>
                    @endforeach
                </h1>
                <div class="flex items-end ml-3 mb-3 text-gray-100 dark-mode:text-gray-200">
                    <svg class="h-8 w-8 mr-6 cursor-pointer hover:text-indigo-500 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg @click="show = false; $dispatch('post-close')" class="h-8 w-8 cursor-pointer hover:text-indigo-500 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="relative">
                @if ($post->postable->getMedia('images')->count() === 1)
                <img class="object-cover" src="{{ $post->postable->getFirstMediaUrl('images') }}">
                @else
                @foreach ($post->postable->getMedia('images') as $image)
                <img x-show="({{ $loop->index }} + 1) === active" class="object-cover" src="{{ $image->getUrl() }}">
                @endforeach
                <div class="absolute left-0 inset-y-0 w-1/3 cursor-pointer" @click="navigate(active === 1 ? count : active - 1)"></div>
                <div class="absolute right-0 inset-y-0 w-1/3 cursor-pointer" @click="navigate(active === count ? 1 : active + 1)"></div>
                @endif
            </div>
        </div>
    </div>
</div>
