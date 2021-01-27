<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
        @else
        <title>{{ config('app.name') }}</title>
        @endif

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <livewire:styles>
        <style>
            [x-cloak] { display: none; }
        </style>
        <script>
            (function() {
                function getInitialColorMode() {
                        const persistedColorPreference = window.localStorage.getItem('nightwind-mode');
                        const hasPersistedPreference = typeof persistedColorPreference === 'string';
                        if (hasPersistedPreference) {
                        return persistedColorPreference;
                        }
                        const mql = window.matchMedia('(prefers-color-scheme: dark)');
                        const hasMediaQueryPreference = typeof mql.matches === 'boolean';
                        if (hasMediaQueryPreference) {
                        return mql.matches ? 'dark' : 'light';
                        }
                        return 'light';
                }
                getInitialColorMode() == 'light' ? document.documentElement.classList.remove('dark') : document.documentElement.classList.add('dark');
                document.documentElement.classList.add('nightwind');
            })()
        </script>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="text-gray-800">
        @yield('body')

        <script src="{{ mix('js/app.js') }}" defer></script>
        <livewire:scripts>
        <script src="{{ mix('js/sort.js') }}"></script>
        <script src="{{ mix('js/night.js') }}"></script>
        @stack('scripts')
    </body>
</html>
