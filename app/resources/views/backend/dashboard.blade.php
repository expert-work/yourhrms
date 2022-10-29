@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30" id="__index_ltn">
        <section class="content p-0 mt-4">
            <div class="row mb-20 padding-right-custom">
                <div class="row col-12 padding-right-custom">
                    <div class="col-12 col-md-8 col-lg-8 col-lg-8 welcome_title">
                        <h3>Welcome to {{ config('settings.app.company_name') }},{{ Auth::user()->name }}</h3>
                    </div>
                    {{-- dropdown menu --}}
                    <div class="col-12 col-md-4 col-lg-4 col-lg-4 padding-right-custom">
                        {{-- <div class="dropdown mr-2 text-left text-md-right text-lg-right text-xl-right"> --}}
                        <div class="dropdown mr-2 float-left float-md-right float-lg-right float-xl-right">
                            <button class="btn btn-secondary filter-btn dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="__selected_dashboard">Company Dashboard</span>
                                {{-- <i class="fa fa-filter"></i> --}}
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item profile_option active" onclick="loadDashboard('My Dashboard')"
                                    href="javascript:void(0)">My Dashboard</a>
                                @if (auth()->user()->role->slug == 'superadmin' && config('app.APP_BRANCH')=='saas')
                                    <a class="dropdown-item company_option" onclick="loadDashboard('Superadmin Dashboard')"
                                        href="javascript:void(0)">Dashboard</a>
                                @endif
                                @if (auth()->user()->role->slug == 'admin' || auth()->user()->role->slug == 'superadmin')
                                    <a class="dropdown-item company_option" onclick="loadDashboard('Company Dashboard')"
                                        href="javascript:void(0)">Company Dashboard</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @if (Auth::user()->role_id == 1)
                {{-- @include('backend.__superadmin_dashboard') --}}
            @endif
        </section>

        <section class="content p-0 mt-4">
            <div class="__MyProfileDashboardView" id="__MyProfileDashboardView"></div>
        </section>

        <section class="content p-0 mt-4 d-none">
            <div class="row mt-primary  ">
                <div class="col-xl-6 mb-primary">
                    <div class="card card-with-shadow border-0">
                        <div
                            class="border-bottom bg-transparent p-primary d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Top 5 Employees</h5>
                            <div
                                class="badge dashboard-badge badge-pill text-capitalize d-flex justify-content-center align-items-center">
                                30
                            </div>
                        </div>
                        <div class="card-body p-primary">
                            <div class="dashboard-widgets dashboard-icon-widget pb-4">
                                <div class="icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-briefcase">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <div class="widget-data">
                                    <h6>15</h6>
                                    <p>Total organizations</p>
                                </div>
                            </div>
                            <div class="dashboard-widgets dashboard-icon-widget pb-4">
                                <div class="icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <div class="widget-data">
                                    <h6>15</h6>
                                    <p>People</p>
                                </div>
                            </div>
                            <div class="dashboard-widgets dashboard-icon-widget pb-4">
                                <div class="icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-circle">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="widget-data">
                                    <h6>0</h6>
                                    <p>Total participants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-primary ">
                    <div class="card card-with-shadow border-0">
                        <div
                            class="border-bottom bg-transparent p-primary d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"></h5>
                            <div
                                class="badge dashboard-badge badge-pill text-capitalize d-flex justify-content-center align-items-center">
                                30
                            </div>
                        </div>
                        <div class="card-body p-primary">
                            <div class="dashboard-widgets dashboard-icon-widget pb-4">
                                <div class="icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-briefcase">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <div class="widget-data">
                                    <h6>15</h6>
                                    <p>Total organizations</p>
                                </div>
                            </div>
                            <div class="dashboard-widgets dashboard-icon-widget pb-4">
                                <div class="icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <div class="widget-data">
                                    <h6>15</h6>
                                    <p>People</p>
                                </div>
                            </div>
                            <div class="dashboard-widgets dashboard-icon-widget pb-4">
                                <div class="icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-circle">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="widget-data">
                                    <h6>0</h6>
                                    <p>Total participants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="user_slug" value="{{ auth()->user()->role->slug }}">
    <input type="hidden" id="__userID" value="{{ Auth::user()->id }}">
    <input type="hidden" id="profileWiseDashboard" value="{{ route('dashboard.profileWiseDashboard') }}">
@endsection
@section('script')
<script src="{{ asset('public/frontend/js/__apexChart.js') }}"></script>
<script src="{{ asset('public/backend/js/admin_dashboard.js') }}"></script>
@endsection
