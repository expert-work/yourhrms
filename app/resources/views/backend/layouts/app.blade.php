<!DOCTYPE html>
@php
App::setLocale(userLocal());
@endphp
<html lang="{{ userLocal() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ config('settings.app.company_name') }} - @yield('title')</title>
    <link rel="icon" href="" type="image/x-icon" />
    @if (env('APP_ENV') == 'server')
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <meta name="base-url" id="base-url" content="{{ env('APP_URL') }}">
    {{-- Header start --}}
    @include('backend.partials.header')
    {{-- Header start --}}
    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed bg-ash">


    <input type="text" hidden value="{{ env('APP_URL') }}" id="url">
    <input type="text" hidden value="{{ config('settings.app.company_name') }}" id="site_name">
    <input type="text" hidden value="{{ \Carbon\Carbon::now()->format('Y/m/d') }}" id="defaultDate">
    <input type="hidden" id="get_custom_user_url" value="{{ route('user.getUser') }}">
    <input hidden value="{{ _trans('project.Select Employee') }}" id="select_custom_members">
    <input hidden value="{{ auth()->id() }}" id="__user_id">

    <div class="wrapper bg-none">
        {{-- Navbar start --}}
        @include('backend.partials.navbar')
        {{-- Navbar start --}}

        {{-- Sidebar start --}}
        @include('backend.partials.sidebar')
        {{-- Sidebar end --}}

        {{-- Content start --}}
        @yield('content')
        {{-- Content end --}}

        {{-- Footer start --}}
        @include('backend.partials.footer')
        {{-- Footer end --}}

    </div>
    {{-- Script start --}}
    @include('backend.partials.script')
    {{-- Script end --}}



    @if (Auth::check() && env('APP_ENV') != 'local')
    <script src="{{ asset('https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js') }}"></script>

    {{-- <script src="{{ url('public/frontend/js/__firebase_app.js') }}" crossorigin="anonymous"></script> --}}



    <script src="{{ asset('https://www.gstatic.com/firebasejs/8.7.1/firebase-messaging.js') }}"></script>

    {{-- <script src="{{ url('public/frontend/js/__firebase_message') }}" crossorigin="anonymous"></script> --}}


    <script type="text/javascript">
        @include('vendor.notifications.init_firebase')
    </script>
    <script src="{{ asset('public/backend/js/__firebase.js') }}"></script>
    @endif

    {{-- Script end --}}
    @include('backend.partials.message')
    {{-- Script end --}}
    {{-- table end --}}
    <script src="{{ asset('public/backend/js/table/table.js') }}"></script>
    {{-- table end --}}
    @yield('script')
    <script src="{{ asset('public/backend/js/backend_common.js') }}"></script>
    <script src="{{ asset('public/backend/js/superfluous_common.js') }}"></script>

    <script src="{{ asset('public/backend/js/__app.script.js') }}"></script>


</body>

</html>