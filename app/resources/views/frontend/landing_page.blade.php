<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/frontend.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">
    {{-- iziToast cdn --}}
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/iziToast.css') }}">

    <link rel="stylesheet" href="{{ asset('/') }}public/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/css/font-icons.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}public/font/flaticon.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/animate.min.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/css/plugins.css">

    <!-- Main Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/slick-theme.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/slick.min.css">

    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/css/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/css/main.css">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/frontend.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/newfrontend.css') }}">

    <link rel="stylesheet" href="{{ asset('public/css/toastr.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}public/fonts/icofont/icofont.css">

    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/css/responsive.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css" />


    <link href="{{ asset('/') }}public/backend/css/select2.min.css" rel="stylesheet" />



    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/css/iziToast.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/css/kobir.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/css/bootstrap-datetimepicker.min.css">


    {{-- movie to --}}
    <link rel="stylesheet" href="{{ asset('/') }}public/frontend/assets/css/header.css">


    @yield('style')
    <title>Landing Page</title>
</head>

<body>
    @include('frontend.includes.landing_menu')
    <div class="bg-for-hrm">
        <figure
            style="height: 100%; background-image: url('{{ url('public/assets/banner-1.png') }}'); background-position: 50% 50%;">
        </figure>
    </div>
    <div class="container">
        <div class="container hrm-title">
            <div class="mini-title ">
                <h4 class="text-white text-center">Most Powerful</h4>
            </div>
            <div class="large-title">
                <h1 class="text-white text-center">Onest HRM</h1>
            </div>
            <div class="mini-title">
                <h4 class="text-white text-center">A powerful platform to make your life easier</h4>
            </div>
            <div class="button-section mt-5">
                <a href="{{url('sign-in')}}"> <button class="backend-demo mr-4">Browse Backend</button> </a>
                <a href="https://play.google.com/store/apps/details?id=com.worx24hour.hrm" target="_blank"><button class="android-demo mr-4">Android App</button></a>
                <a href="https://apps.apple.com/us/app/24hourworx/id1620313188" target="_blank"><button class="android-demo">Ios App</button></a>
            </div>
        </div>
        <section class="mt-5 mb-5 works-section">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">How <span class="primary-highlight">Onest HRM</span> Works</h2>
                </div>
                <div class="col-md-3">
                    <div class="card-one">
                        <div class="card-body">
                            <div class="bg-white bg-circle works-icon-bg">
                                <i class="fas fa-download"></i>
                            </div>
                            <h3 class="text-center mt-2">01</h3>
                            <p class="text-center">Download and Install Onest HRM</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-two">
                        <div class="card-body">
                            <div class="bg-white bg-circle works-icon-bg">
                                <i class="fas fa-download"></i>
                            </div>
                            <h3 class="text-center mt-2">01</h3>
                            <p class="text-center">Download and Install Onest HRM</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-three">
                        <div class="card-body">
                            <div class="bg-white bg-circle works-icon-bg">
                                <i class="fas fa-download"></i>
                            </div>
                            <h3 class="text-center mt-2">01</h3>
                            <p class="text-center">Download and Install Onest HRM</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-four">
                        <div class="card-body">
                            <div class="bg-white bg-circle works-icon-bg">
                                <i class="fas fa-download"></i>
                            </div>
                            <h3 class="text-center mt-2">01</h3>
                            <p class="text-center">Download and Install Onest HRM</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="backend-design-section mt-5 mb-5">
            <h2 class="text-center"> <span class="primary-highlight">Backend</span> Design</h2>
            <p class="text-center">
                Unique shop design to make your business more powerful
            </p>

            <div class="slick-backend-design">
                <img src="{{ url('public/assets/slider-1.png') }}"
                    class="" alt="" loading="lazy">
                <img src="{{ url('public/assets/slider-2.png') }}"
                    class="" alt="" loading="lazy">
                <img src="{{ url('public/assets/slider-3.png') }}"
                    class="" alt="" loading="lazy">
                <img src="{{ url('public/assets/slider-4.png') }}"
                    class="" alt="" loading="lazy">
                <img src="{{ url('public/assets/slider-5.png') }}"
                    class="" alt="" loading="lazy">
                <img src="{{ url('public/assets/slider-dashboard-dark.png') }}"
                    class="" alt="" loading="lazy">

            </div>

        </section>

        <section class="amazing-feature mt-5 mb-5">
            <h2 class="text-center"> Amazing Features</h2>
            <p class="text-center">
                Unique shop design to make your business more powerful
            </p>

            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-white border-none shadow-light">
                        <div class="card-body">
                            <div class="bg-red-hrm bg-circle-light icon-white">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <h6 class="amazing-title text-center mt-2">Laravell based PHP script</h6>
                            <p class="text-muted text-center">Developed with most powerful PHP framework <span
                                    class="text-red-hrm">Laravel</span> </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border-none shadow-light">
                        <div class="card-body">
                            <div class="bg-blue-hrm bg-circle-light icon-white">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h6 class="amazing-title text-center mt-2">100% Responsive design</h6>
                            <p class="text-muted text-center">The entire layout is available to <span
                                    class="text-blue-hrm">100% fit</span> for any sizes of screen </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border-none shadow-light">
                        <div class="card-body">
                            <div class="bg-orange-hrm bg-circle-light icon-white">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h6 class="amazing-title text-center mt-2">Multivendor system</h6>
                            <p class="text-muted text-center">Complete system for making your <span
                                    class="text-orange-hrm">Multivendor </span> system </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border-none shadow-light">
                        <div class="card-body">
                            <div class="bg-red-hrm bg-circle-light icon-white">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <h6 class="amazing-title text-center mt-2">Laravell based PHP script</h6>
                            <p class="text-muted text-center">Developed with most powerful PHP framework <span
                                    class="text-red-hrm">Laravel</span> </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border-none shadow-light">
                        <div class="card-body">
                            <div class="bg-blue-hrm bg-circle-light icon-white">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h6 class="amazing-title text-center mt-2">100% Responsive design</h6>
                            <p class="text-muted text-center">The entire layout is available to <span
                                    class="text-blue-hrm">100% fit</span> for any sizes of screen </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border-none shadow-light">
                        <div class="card-body">
                            <div class="bg-orange-hrm bg-circle-light icon-white">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h6 class="amazing-title text-center mt-2">Multivendor system</h6>
                            <p class="text-muted text-center">Complete system for making your <span
                                    class="text-orange-hrm">Multivendor </span> system </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="all-feature text-center mt-3">
                        <a href=""> <button class="feature-btn">View All Features </button> </a>
                    </div>
                </div>
            </div>

        </section>
    </div>
        <section class=" mt-5 mb-5 user-interface">
            <div class="container">
                <div class="col-lg-12">
                    <div class="side-content">
                        <h2 class="text-center gradiant-color">User Panel</h2>
                        <p class="text-center">Efficient customer, seller & shop owner panel to manage HRM system.</p>
                        <div class="row">
                            <div class="col-lg-6 pr-5">
                                <ul class="nav nav-tabs business-tabs user-panel-tabs d-block " id="myTab"
                                    role="tablist">
                                    <li class="nav-item user-panel-item" role="presentation">
                                        <button class="nav-link user-panel-link active" id="hrcalendar-tab"
                                            data-bs-toggle="tab" data-bs-target="#hrcalendar" type="button"
                                            role="tab" aria-controls="hrcalendar" aria-selected="true">
                                            <span class="user-tab-header">Efficicent Seller Panel </span> <br>
                                            <span class="user-tab-content">Organized seller panel to manage products,
                                                orders, income. Every seller has a
                                                separate shop.</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="banking-tab" data-bs-toggle="tab"
                                            data-bs-target="#banking" type="button" role="tab"
                                            aria-controls="banking" aria-selected="false"><span
                                                class="user-tab-header">Powerfull Admin Panel </span> <br>
                                            <span class="user-tab-content">Behind this whole system there is a powerful
                                                admin panel from where admin can manage full system.</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="designdevice-tab" data-bs-toggle="tab"
                                            data-bs-target="#designdevice" type="button" role="tab"
                                            aria-controls="designdevice" aria-selected="false"><span
                                                class="user-tab-header">Exclusive Customer Profile </span> <br>
                                            <span class="user-tab-content">Purchase & order history, profile image,
                                                information and shipping address are editable.</span></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="hrcalendar" role="tabpanel"
                                        aria-labelledby="hrcalendar-tab">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="side-img">
                                                        <img src="{{ url('public/images/nav_pic1.png') }}"
                                                            alt="">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="banking" role="tabpanel"
                                        aria-labelledby="banking-tab">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="side-img">
                                                        <img src="{{ url('public/images/nav_pic2.png') }}"
                                                            alt="">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="designdevice" role="tabpanel"
                                        aria-labelledby="designdevice-tab">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="side-img">
                                                        <img src="{{ url('public/images/nav_pic3.png') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        {{-- <section id="price" class="price">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-4">Affordable <span class="primary-highlight">Pricing</span></h2>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-light border-none">
                            <div class="card-body">
                                <p class="text-center mb-0 mt-5">REGULAR</p>
                                <h2 class="text-center">$99</h2>
                                <div class="pricing-table">
                                    <ul class="list-style-none m-auto">
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Lifetime update</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>On Demand Support</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Server/Environment Setup <span style="font-size: 12px" class="badge badge-pill badge-danger">+&#36;45</span> </span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Publish App Android/IOS</span></li>
                                       <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Multiple Package System</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Subscription System</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Multiple Payment Gateways</span></li>
                                    </ul>
                                </div>
                                <div class="pricing-button text-center">
                                    <a href="">
                                        <button class="btn btn-outline-primary price-btn">Buy Regular License</button>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-light border-none">
                            <div class="card-body">
                                <p class="text-center mt-5 mb-0">SINGLE COMPANY EXTENDED</p>
                                <h2 class="text-center">$299</h2>
                                <div class="pricing-table">
                                    <ul class="list-style-none m-auto">
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Lifetime update</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>On Demand Support</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Server/Environment Setup <span style="font-size: 12px" class="badge badge-pill badge-success">Free</span></span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Publish App Android/IOS</span></li>
                                       <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Multiple Package System</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Subscription System</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"><span style="font-size: 15px;color: #ee316b"><i class="fa fa-fw" title="Copy to use close" aria-hidden="true"></i></span> </i></span>Multiple Payment Gateways</span></li>
                                    </ul>
                                </div>
                                <div class="pricing-button text-center">
                                    <a href="">
                                        <button class="btn btn-outline-primary price-btn">Buy Single Company License</button>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-light border-none">
                            <div class="card-body">
                                <p class="text-center mb-0 mt-5">MULTI COMPANY EXTENDED</p>
                                <h2 class="text-center">$699</h2>
                                <div class="pricing-table">
                                    <ul class="list-style-none m-auto">
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Lifetime update</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>On Demand Support</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Server/Environment Setup <span style="font-size: 12px" class="badge badge-pill badge-success">Free</span></span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Publish App Android/IOS</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Multiple Package System</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Subscription System</span></li>
                                        <li><span style="font-size: 15px"><span style="color: #81b441"><i class="fa fa-fw" title="Copy to use check" aria-hidden="true"> </i></span>Multiple Payment Gateways</span></li>
                                    </ul>
                                </div>
                                <div class="pricing-button text-center">
                                    <a href="">
                                        <button class="btn btn-outline-primary price-btn">Buy Multi Company License</button>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section> --}}
        <section class="postig">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="mockup-img">
                            <img src="{{url('public/assets/dashboard-mockup.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="posting-bg">
                <div class="container">
                    <div class="wp-50 m-auto">
                        <h2 class="text-center">Easy Employee Tracking</h2>
                        <p class="text-center">An efficient and thoughtfully streamlined product posting option for admins and sellers makes it possible to provide an industry-leading standard.</p>
                    </div>
                    <div class="posting-card">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Daily Check in/out</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Daily Leave Approved/Rejected</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Daily Break</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Birthday Wish to colleagues</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Daily Expense </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Check Appoinments</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Notice/Events</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-none shadow-light">
                                    <div class="card-body">
                                        <div class="bg-circle-light-more shadow-light m-auto icon-orange">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>

                                          <h6 class="mt-3 text-center">Holiday</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
        <section class="payment-gateway mt-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="gateway-img pb-5">
                            <img src="{{url('public/assets/payment-gateway-tree.png')}}" alt="">
                        </div>

                    </div>
                    <div class="col-md-5 pl-5">
                        <div class="gateway-title">
                            <h2 class=" gradiant-color gateway-content-title">Multiple Payment Gateways</h2>
                            <p>Onest HRM comes with 8 types of payment options. You can take payments from your customers according to your suitable gateways.</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="user-interface presenting">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="presentation-title">
                            <h2 class=" gradiant-color gateway-content-title">Single Company Admin</h2>
                            <p>All sellers have their shop setting to present his/her store branding. Store page comes with promotional banners,  featured products, sellers reviews, social links, new products.</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="presentation-img">
                            <img src="{{url('public/assets/single-company-dashboard.png')}}" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="business-handle mt-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="business-handle-img">
                            <img src="{{url('public/assets/multi-company-dashboard.png')}}" alt="">
                        </div>

                    </div>
                    <div class="col-md-4 pl-5">
                        <div class="presentation-title">
                            <h2 class=" gradiant-color gateway-content-title">Multi Company Admin</h2>
                            <p>Admin panel of Onest HRM  is a control room of your business. You can manage your whole business including customers, products, orders, sellers, shops. Is has everything you need to control your shop business.</p>
                        </div>
                    </div>
                </div>
            </div>

        </section>

</body>
@include('frontend.includes.footer')


</html>
