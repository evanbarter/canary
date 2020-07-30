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
                if (index === 'next') {
                    index = this.active === this.count ? 1 : this.active + 1
                } else if (index === 'prev') {
                    index = this.active === 1 ? this.count : this.active - 1
                }
                this.active = index
            }
        }
    }
    function commentForm() {
        return {
            save() {
                if (typeof this.$refs.comment.value !== 'undefined') {
                    window.livewire.emit('commentSave', {
                        comment: this.$refs.comment.value
                    })
                }
            }
        }
    }
</script>
@endpush
