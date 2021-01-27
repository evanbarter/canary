@extends('layouts.base')

@section('body')
    @isset($slot)
        {{ $slot }}
    @else
        @yield('content')
    @endisset
@endsection
