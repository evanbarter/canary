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
    <div class="text-sm sm:text-base dark-mode:text-gray-200">
        {!! $post->postable->text !!}
    </div>
</div>