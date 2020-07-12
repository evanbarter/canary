<div x-show="$store.postModal.open === '{{ $type }}'" class="fixed z-50 inset-0 px-4 pb-4 flex items-center justify-center">
    <div
        x-show="$store.postModal.open === '{{ $type }}'"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 transition-opacity">
      <div @click="$store.postModal.open = null; window.livewire.emit('postEditorStopEditing')" class="absolute inset-0 bg-gray-500 dark-mode:bg-gray-800 opacity-75"></div>
    </div>

    <div
        x-show="$store.postModal.open === '{{ $type }}'"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all w-full sm:max-w-3xl dark-mode:border dark-mode:bg-gray-900 dark-mode:border-gray-800"
        role="dialog"
        aria-modal="true">
        @livewire('post.editor.' . $type)
    </div>
</div>
@push('scripts')
<script >
    window.livewire.on('postEditorSaved', () => {
        Spruce.store('postModal').open = null
    })
</script>
@endpush