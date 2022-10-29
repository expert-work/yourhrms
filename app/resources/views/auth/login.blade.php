@extends('backend.auth.app')
@section('title', 'Login')
@section('content')
    <div class="container login-card-custom">
        <div class="cus-card">
            <div class="card-body login-card-body">
                <div class="mb-4">
                    <p class="login-box-msg cus-login-box-msg">{{ __('Log in to your dashboard') }}</p>
                </div>
                <form action="" method="post" id="login" class="__login_form">
                    @csrf
                    <input type="hidden" hidden name="is_email" value="1">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="{{ _trans('common.Email') }}">
                    </div>
                    <p class="text-danger __phone small-text"></p>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <p class="text-danger __password small-text"></p>
                    <div class="row">
                        <div class="col-md-12 mx-auto text-center">
                            <a href="{{ route('password.forget') }}"
                                class="bluish-text d-flex justify-content-lg-start m-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-lock pr-2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                Forgot password?</a>
                            <button type="button" class="login-panel-btn  __login_btn mb-3">Sign In</button>
                        </div>
                    </div>
                    {{-- <div
                        class="form-row flex-column flex-md-row justify-content-center justify-content-md-between justify-content-lg-between">
                        <a href="{{ route('user.signup') }}"
                            class="bluish-text d-flex align-items-center justify-content-center justify-content-lg-end mr-2">
                            <span style="font-size: 16px" class="text-muted">Don't have an account?</span>&nbsp;Sign up
                            as company or team</a>
                    </div> --}}
                </form>
                @if (env('APP_SYNC') == 'true')
                    <a class="btn btn-primary login-panel-btn mt-2" data-toggle="collapse" href="#demoLogin" role="button"
                        aria-expanded="false" aria-controls="demoLogin">
                        Expend Demo Login
                    </a>
                    <div class="collapse mt-5" id="demoLogin">
                        <div class="card card-body">

                            <div class="">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <small style="font-size: 20px">Login as</small>
                                    </div>
                                </div>
                                @foreach (App\Models\User::with('role', 'company')->groupBy('company_id')->get() as $user)
                                    <div class="d-flex">
                                        <form action="" method="post">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ $user->email }}" readonly>
                                            <input type="hidden" name="password" value="12345678">
                                            <button type="button"
                                                class="login-panel-btn __demo_login_btn admin-login-btn"><span>{{ ucfirst($user->role->name) }}
                                                    <br>
                                                    ({{ ucfirst(@$user->company->name) }})
                                                </span>
                                            </button>
                                            <p class="mt-2" style="font-size: 12px">{{ ucfirst($user->name) }}
                                            </p>
                                        </form>
                                    </div>

                                @endforeach
                                @foreach (App\Models\User::with('role', 'company')->groupBy('company_id')->where('role_id', 7)->get()
        as $user)

                                        <form action="" method="post">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ $user->email }}" readonly>
                                            <input type="hidden" name="password" value="12345678">
                                            <button type="button"
                                                class="login-panel-btn __demo_login_btn admin-login-btn"><span>{{ ucfirst($user->role->name) }}
                                                    <br>
                                                    ({{ ucfirst(@$user->company->name) }})
                                                </span>
                                            </button>
                                            <p class="mt-2" style="font-size: 12px">{{ $user->email }} </p>
                                        </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var baseUrl = $('meta[name="base-url"]').attr('content');
            let URL = $('#url').val();
            //user login


            $(".__demo_login_btn").on('dblclick', function(event) {
                event.preventDefault();
            });
            $(".__login_btn").on('dblclick', function(event) {
                event.preventDefault();
            });


            $(".__login_btn").click(function(event) {
                event.preventDefault();
                let formData = $('.__login_form').serialize();

                $('.__phone').text("")
                $('.__password').text("")
                $.ajax({
                    url: baseUrl + "/admin-login",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response === '0') {
                            iziToast.success({
                                title: 'Success',
                                message: "Login successfully",
                                position: 'topRight'
                            });

                            $('.__phone').text("")
                            $('.__password').text("")
                            $('.__login_form').trigger('reset');
                            $('.__login_btn').text('Redirecting..');
                            setTimeout(() => {
                                window.location.replace(baseUrl + "/dashboard");
                            }, 1500)
                        } else {
                            window.location.replace(baseUrl);
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error.email) {
                            $('.__phone').text(error.responseJSON.error.email[0])
                        }
                        if (error.responseJSON.error.password) {
                            $('.__password').text(error.responseJSON.error.password[0])
                        }
                    }
                });
            });



            $('.__demo_login_btn').on('click', function() {
                event.preventDefault();
                let formData = $(this).closest('form').serialize();
                console.log(formData);
                console.log(baseUrl + "/admin-login");
                $.ajax({
                    url: baseUrl + "/admin-login",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response === '0') {
                            iziToast.success({
                                title: 'Success',
                                message: "Login successfully",
                                position: 'topRight'
                            });

                            $('.__phone').text("");
                            $('.__password').text("");
                            $('.__login_form').trigger('reset');
                            $('.__login_btn').text('Redirecting..');
                            setTimeout(() => {
                                window.location.replace(baseUrl + "/dashboard");
                            }, 1500)
                        } else {
                            window.location.replace(baseUrl);
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error.email) {
                            $('.__phone').text(error.responseJSON.error.email[0])
                        }
                        if (error.responseJSON.error.password) {
                            $('.__password').text(error.responseJSON.error.password[0])
                        }
                    }
                });
            });
        });
    </script>
@endsection
