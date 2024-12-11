@extends('layouts.app')

@section('auth')

    @if(\Request::is('static-sign-up'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')



    @elseif (\Request::is('profile'))
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>

    @elseif (\Request::is('roles.users.list'))
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>

    @elseif (\Request::is('roles.users.create-update'))
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>

    @elseif (\Request::is('dashboard'))
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>

    @else
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">

                @yield('content')
                @include('layouts.footers.auth.footer')

            </div>
        </main>
    @endif


@endsection
