@extends('layouts.app')

@section('content')
    @if (!auth()->user())
    <div class="flex p-2 bg-white justify-end">
        <span class="text-xs sm:text-sm" x-data="{ selected: document.documentElement.classList.contains('dark') ? 'dark' : 'light' }">
            <div class="p-2 rounded-lg hover:bg-gray-100 cursor-pointer" x-on:click="selected = selected === 'dark' ? 'light' : 'dark'; nightwind.toggle();">
                <span x-text="selected === 'dark' ? '☀️' : '🌒'"></span> {{ __('Toggle') }}
            </div>
        </span>
    </div>
    @endif

    <div x-cloak x-data="{}" x-subscribe>
        <x-post.modal type="image" />
        <x-post.modal type="text" />
    </div>

    <div class="h-full min-h-screen shadow-inner @if (auth()->user()) pb-16 @endif">
        @livewire('post.view-post')
        @livewire('post.list-posts')
    </div>
    @if (auth()->user())
    <div class="fixed bottom-0 inset-x-auto flex justify-between items-center h-16 w-full px-8 bg-white shadow-inner">
        <div class="flex-1">
            <a class="border-b-2 uppercase text-sm font-medium mr-6 @if(Route::currentRouteName() === 'home' || request()->is('post/*')) border-gray-700 text-gray-700 @else border-gray-400 text-gray-400 hover:text-gray-500 @endif" href="{{ route('home') }}">{{ __('You') }}</a>
            <a class="border-b-2 uppercase text-sm font-medium mr-3 @if(request()->is('feed*')) border-gray-700 text-gray-700 @else border-gray-400 text-gray-400 hover:text-gray-500 @endif" href="{{ route('feed') }}">{{ __('Feed') }}</a>
        </div>
        <div class="flex-none relative" x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false">
            <button @click="open = !open" class="p-2 shadow-md rounded-lg bg-gradient-brand border border-red-400 active:bg-indigo-800 active:border-indigo-800 focus:outline-none">
                <svg class="h-4 w-4 text-white" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"></path></svg>
            </button>
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="origin-bottom absolute inset-x-0 bottom-0 mb-10 w-40 sm:w-56 rounded-md shadow-lg">
                <div @click="open = !open" class="rounded-md bg-white shadow-xs">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" x-data="{}" x-subscribe x-cloak>
                        <a href="#" @click="$store.postModal.open = 'image'" class="block px-4 py-2 text-xs sm:text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">
                            <svg class="inline-block mr-2 h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ __('Image') }}
                        </a>
                        <a href="#" @click="$store.postModal.open = 'text'" class="block px-4 py-2 text-xs sm:text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">
                            <svg class="inline-block mr-2 h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            {{ __('Post') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 flex items-center justify-end">
            <span x-data="{ selected: document.documentElement.classList.contains('dark') ? 'dark' : 'light' }">
                <div class="p-2 text-xs sm:text-sm rounded-lg hover:bg-gray-100 cursor-pointer" x-on:click="selected = selected === 'dark' ? 'light' : 'dark'; nightwind.toggle();">
                    <span x-text="selected === 'dark' ? '☀️' : '🌒'"></span> {{ __('Toggle') }}
                </div>
            </span>
            <a href="{{ route('settings') }}" class="float-right p-2 rounded-lg hover:bg-gray-100 active:bg-gray-200 focus:outline-none">
                <svg class="h-6 w-6 text-gray-900" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </a>
        </div>
    </div>
    @endif
@endsection
