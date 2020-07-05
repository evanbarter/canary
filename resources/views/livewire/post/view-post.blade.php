<div x-data="postView()" @post-close.window ="close">
    @if ($post)
    @include('components.post.view.' . $post->postable_type, ['post' => $post])
    @endif
</div>
@push('scripts')
<script>
    function postView() {
        return {
            close() {
                const path = window.location.pathname.split('/')[1] !== 'post' ? window.location.pathname.split('/')[1] : ''
                window.history.pushState({}, '', '/' + path)
                window.livewire.emit('postViewClose')
            }
        }
    }
    function gallery() {
        return {
            active: 1,
            count: 1,
            init(count) {
                this.count = count
            },
            navigate(index) {
                this.active = index
            }
        }
    }
</script>
@endpush
