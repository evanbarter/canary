<div x-data="postList()" x-init="init()" class="flex justify-center">
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="grid w-4/5 p-8 grid-cols-1 sm:grid-cols-3 gap-8 z-0">
        @if (!$feed && count($pinned))
        @foreach($pinned as $post)
        @include('components.post.list.' . $post->postable_type, ['post' => $post])
        @endforeach
        <div class="col-span-1 sm:col-span-3">
            <hr class="border-gray-300">
        </div>
        @endif
        @foreach($posts as $post)
        @include('components.post.list.' . $post->postable_type, ['post' => $post])
        @endforeach
    </div>
</div>
@push('scripts')
<script>
    function postList() {
        return {
            show: {{ $show ? 'true' : 'false' }},
            view(post) {
                const path = window.location.pathname !== '/' ? window.location.pathname : ''
                window.history.pushState({}, '', path + '/post/' + post)
                window.livewire.emit('postViewOpen', post)
            },
            init() {
                window.livewire.on('hideList', () => {
                    this.show = false
                })
                window.livewire.on('postViewClose', () => {
                    this.show = true
                })
            }
        }
    }
</script>
@endpush
