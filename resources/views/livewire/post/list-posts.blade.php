<div class="flex justify-center">
    <div x-data="postViewer()" class="grid max-w-7xl p-8 grid-cols-1 sm:grid-cols-3 gap-8 z-0">
        @foreach($posts as $post)
        <div x-on:click="view({{ $post->id }})" class="flex flex-col p-4 h-64 shadow-xl text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 dark-mode:bg-gray-800 dark-mode:hover:bg-gray-900 dark-mode:text-gray-200 dark-mode:hover:text-gray-400 cursor-pointer">
            <h2 class="h-full w-full font-serif font-bold italic text-2xl leading-tight break-words">{{ $post->title }}</h2>
            <span class="text-right text-xs" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
        </div>
        @endforeach
    </div>
</div>
@push('scripts')
<script>
    function postViewer() {
        return {
            view(post) {
                window.history.pushState({}, '', '/post/' + post)
                window.livewire.emit('postViewOpen', post)
            }
        }
    }
</script>
@endpush