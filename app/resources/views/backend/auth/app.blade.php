<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ env('APP_URL') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('settings.app.company_name') }} - @yield('title')</title>
    <link rel="icon" href="" type="image/x-icon" />
    @if (env('APP_ENV') == 'server')
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    @if (env('FILESYSTEM_DRIVER') == 'server')
    <link rel="shortcut icon" href="{{ Storage::disk('s3')->url(config('settings.app')['company_icon']) }}"
        type="image/x-icon" />
    @elseif(env('FILESYSTEM_DRIVER') == 'local')
    <link rel="shortcut icon" href="{{ Storage::url(config('settings.app')['company_icon']) }}" type="image/x-icon" />
    @else
    <link rel="shortcut icon" href="{{ Storage::url(config('settings.app')['company_icon']) }}" type="image/x-icon" />
    @endif

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/adminlte.min.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/toastr.css') }}">
    {{-- iziToast cdn --}}
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/iziToast.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/')}}/plugins/select2/css/select2.min.css">

    {{-- intarnal stylesheet moved to app.css --}}
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/app.css')}}">

    <link rel="stylesheet" href="{{ asset('public/frontend/css/frontend.css')}}">

    @yield('style')
</head>

<body class="hold-transition ">
    {{-- @include('frontend.includes.menu') --}}

    <div class="row">
        {{-- <div class="login-container login-page col-lg-8  md-none">

        </div> --}}
        <div class=" col-md-12  my-auto">

            <div class=" new-main-content1">
                @yield('content')
            </div>
            <!-- /.login-logo -->

        </div>
        <!-- /.login-box -->
    </div>
    @include('frontend.includes.footer')