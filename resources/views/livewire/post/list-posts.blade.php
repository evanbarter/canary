<div class="flex justify-center">
    <div x-data="postViewer()" class="grid max-w-7xl p-8 grid-cols-1 sm:grid-cols-3 gap-8 z-0">
        @foreach($posts as $post)
        @include('components.post.list.' . $post->postable_type, ['post' => $post])
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