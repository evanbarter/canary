<div x-data="post()">
    @if ($post)
    <div class="fixed z-50 inset-0 px-4 m-8 sm:m-12 flex items-center justify-center">
        <div @click="close"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity">
          <div class="absolute inset-0 bg-gray-700 dark-mode:bg-gray-800 opacity-75"></div>
        </div>
        <div class="flex flex-col min-h-full max-h-11/12 w-full sm:max-w-6xl z-50">
            <div class="flex justify-end mb-3 text-gray-100 dark-mode:text-gray-200">
                <svg class="h-10 w-10 mr-4 cursor-pointer hover:text-indigo-200 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <svg @click="close" class="h-10 w-10 cursor-pointer hover:text-indigo-200 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="bg-white rounded-lg p-8 shadow-xl transform transition-all overflow-y-scroll dark-mode:border dark-mode:bg-gray-900 dark-mode:border-gray-800"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline">
                <h1 id="modal-headline" class="mb-4 font-serif font-bold italic text-xl sm:text-3xl leading-tight text-gray-700 dark-mode:text-gray-400">{{ $post->title }}</h1>
                <div class="text-sm sm:text-base dark-mode:text-gray-200">
                    {!! $post->postable->text !!}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@push('scripts')
<script>
    function post() {
        return {
            close() {
                window.history.pushState({}, '', '/')
                window.livewire.emit('postViewClose')
            }
        }
    }
</script>
@endpush