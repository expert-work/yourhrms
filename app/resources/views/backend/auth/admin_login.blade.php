@extends('backend.auth.app')
@section('title', 'Login')
@section('content')
<div class="login_page_bg">
    <div class="">
        @include('backend.auth.hrm_logo')
        <div class="screen">
            <div class="screen__content">
                <div class="ml-4 pt-5 __logo d-flex">

                    <h2 class="adminpanel-title  mb-0 pl-2 ">Login</h2>

                </div>
                <div class="login">

                    <form action="{{ route('login') }}" method="post" id="login" class="__login_form ">
                        @csrf

                        <input type="hidden" hidden name="is_email" value="1">
                        <div class="login__field ">

                            <input type="email" name="email" class="login__input mb-1" placeholder="Email">
                        </div>
                        <p class="text-danger __phone small-text"></p>
                        <div class="login__field">

                            <input type="password" name="password" class="login__input mb-1" placeholder="Password">
                        </div>
                        <p class="text-danger __password small-text"></p>
                        <div class="row">
                            <div class="col-md-12 ">
                                <a href="{{ route('password.forget') }}"
                                    class="bluish-text d-flex justify-content-lg-start mb-3 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-lock pr-2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    {{ _trans('auth.Forgot password?') }}</a>
                                <button type="submit" class="login-panel-btn  __login_btn mb-3"> {{ _trans('auth.Sign In') }}</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>

        </div>
        @if (@$users != null)
        <div class="container mt-30">
            <div class="row bg-white default-login-container">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Email
                                </th>
                                <th class="text-center">
                                    Password
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="text-left">
                                        <strong>{{ $user->name }}</strong>
                                        <br>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    12345678
                                </td>
                                <td>
                                    <form action="" class="mr-2 mb-10" method="post">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $user->email }}" readonly>
                                        <input type="hidden" name="password" value="12345678">
                                        <button type="button" class="login-panel-btn  __demo_login_btn admin-login-btn">
                                            Login
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('script')

<script src="{{asset('public/frontend/js/registration.js')}}"></script>
@endsection