<div x-data="post()">
    @if ($post)
    <div class="fixed z-50 inset-0 px-4 m-8 sm:m-12 flex items-center justify-center">
        <div @click="close" class="fixed inset-0">
          <div class="absolute inset-0 bg-black dark-mode:bg-black opacity-85"></div>
        </div>
        <div class="flex flex-col min-h-full max-h-11/12 w-full sm:max-w-4xl z-50">
            <div class="flex">
                <h1 id="modal-headline" class="flex-1 mb-4 font-serif font-bold italic text-xl sm:text-3xl leading-tight text-white shadow-sm dark-mode:text-gray-400">{{ is_array($post->postable->title) ? $post->postable->title[0] : $post->postable->title }}</h1>
                <div class="flex items-end justify- ml-3 mb-3 text-gray-100 dark-mode:text-gray-200">
                    <svg class="h-10 w-10 mr-4 cursor-pointer hover:text-indigo-200 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg @click="close" class="h-10 w-10 cursor-pointer hover:text-indigo-200 transition-colors duration-200" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            @include('components.post.view.' . $post->postable_type, ['post' => $post])
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