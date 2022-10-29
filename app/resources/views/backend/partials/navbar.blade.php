<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
        <li class="nav-item navbar-nav-toggler">
            <a class="nav-link clickable-sidebar" data-widget="pushmenu" href="#" role="button">
                <i class="bi bi-text-left"></i>
                <i class="bi bi-text-right"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
             <a class="nav-link company_section" href="#">
                <div class="company_name_header fs-16" id="company_name_header">{{ auth()->user()->company->name }}</div>
             </a>
        </li> --}}
    </ul>
    <!-- SEARCH FORM -->
    <div class="flex-container">
        <ul class="navbar-nav ml-auto navbar-flex top-header-navbar">
            <li class="nav-item dropdown ">
                <a class="nav-link __clock_nav" href="javascript:void(0)">
                    <div class="clock company_name_clock fs-16 clock" id="clock" onload="currentTime()">00:00:00
                    </div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <div class="">
                    <input type="hidden" id="change_lang_url" value="{{ route('language.ajaxLangChange') }}">
                    <div class="form-group mb-0">
                        <select name="user_lang" class="form-control select2" id="select-user-lang">
                            @foreach (app()->hrm_languages as $language)
                                <option value="{{ $language->language->code }}"
                                    {{ $language->language->code == userLocal() ? 'selected' : '' }}>
                                    {{ $language->language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </li>

            <li>
                <div class="float-sm-right d-flex">
                    @if (!isAttendee()['checkin'] && auth()->user()->role_id != 1)
                        <a id="demo" onclick="viewModal(`{{ route('admin.ajaxDashboardCheckinModal') }}`)"
                            class="ml-2 mr-2 btn checkin d-flex align-items-center sm-btn-with-radius">
                            <img class="checkin-out-icon" src="{{ url('public/assets/in.gif') }}" alt="">
                        </a>
                    @endif
                    @if (isAttendee()['checkin'] && !isAttendee()['checkout'])
                        <a onclick="viewModal(`{{ route('admin.ajaxDashboardCheckOutModal') }}`)"
                            class="ml-2 mr-2 btn d-flex btn-danger align-items-center sm-btn-with-radius">
                            <img class="checkin-out-icon" src="{{ url('public/assets/out.gif') }}" alt="">
                        </a>
                        <input type="text" hidden value="{{ url('public/assets/coffee-break.png') }}"
                            id="break_icon">
                        <span class="break_back_button">
                            @if (isBreakRunning() == 'start')
                                <button onclick="breakBack(`{{ route('admin.dashboardBreakBack', 'start') }}`)"
                                    class="ml-2 mr-2 btn btn-danger box-shadow d-flex align-items-center sm-btn-with-radius ">
                                    <img class="zoom-in-zoom-out" src="{{ url('public/assets/coffee-break.png') }}"
                                        alt="" style=" width: 19px; height: 19px; padding:0px !important">
                                </button>
                            @else
                                <button data-toggle="modal" data-target="#exampleModal"
                                    class="ml-2 mr-2 btn btn-info box-shadow d-flex align-items-center sm-btn-with-radius">
                                    <img class="zoom-in-zoom-out" src="{{ url('public/assets/coffee-break.png') }}"
                                        alt="" style=" width: 19px; height: 19px; padding:0px !important">
                                </button>
                            @endif
                        </span>

                    @endif
                    @if (isAttendee()['checkin'] && isAttendee()['checkout'])
                        <a id="demo" onclick="viewModal(`{{ route('admin.ajaxDashboardCheckinModal') }}`)"
                            class="ml-2 mr-2 btn checkin d-flex align-items-center sm-btn-with-radius">
                            <img class="checkin-out-icon" src="{{ url('public/assets/in.gif') }}" alt="">
                        </a>
                        {{-- <span
                            class="btn btn-primary ">{{ $data['attendance']['in_time'] . ' - ' . $data['attendance']['out_time'] }}</span> --}}
                    @endif

                </div>
            </li>

            <li class="nav-item dropdown md-device-hide notification_panel common-dropdown-btn mr-0"
                id="notification_panel">
                <span class="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                <a class="nav-link feather-bell" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather ">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </a>

                {{-- notifications --}}
                <div class="notification-panel dropdownAnimation common-dropdown-content">
                    <h4 class="notification-panel-header">Notifications</h4>
                    <ul class="notifications">
                        @forelse (auth()->user()->unreadNotifications  as $key => $notification)
                            @php
                                if ($key > 5) {
                                    continue;
                                }
                            @endphp
                            <li class="notification unread_notification" data-notification_id="{{ $notification->id }}"
                                style="cursor: pointer;"><i class="notification-icon fa fa-dropbox"></i>
                                <div class="notification-content">
                                    <span class="notification-title">{{ @$notification->data['title'] }}</span>
                                    <div class="muted truncate">{!! @$notification->data['body'] !!}</div>
                                </div>
                                <div class="notification-time">{{ @$notification->created_at->diffForHumans() }}
                                </div>
                            </li>
                        @empty
                            <p>No Notification Found</p>
                        @endforelse
                    </ul>
                    <footer class="notification-panel-footer">
                        <a href="{{ route('notification.index') }}" class="btn btn-primary text-capitalize">View
                            All</a>

                    </footer>
                </div>
                {{-- notifications --}}

            </li>
            <li class="nav-item dropdown profile_dropdown_panel common-dropdown-btn mr-0">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0">
                    <div class=" pl-2 pr-2 admin-img flex-container">
                        <div class="flex-item-left-img"><img src="{{ uploaded_asset(@Auth::user()->avatar_id) }}"
                                alt="" width="20"></div>
                    </div>
                </a>
                <div
                    class="dropdown-menu dropdown-menu-right profile-custom-dropdown dropdownAnimation common-dropdown-content">
                    <div class="dropdown-item profile white-space-normal">
                        <div class="avatars-w-50"><img src="{{ uploaded_asset(@Auth::user()->avatar_id) }}"
                                alt="image" class="rounded-circle">
                            <!---->
                        </div>
                        <div class="nav-profile-text font-size-default ml-2">
                            <p class="my-0 text-black font-weight-bold">
                                {{ @Auth::user()->name }}
                            </p>
                            <span class="text-secondary font-size-90">
                                {{ @Auth::user()->designation->title }}, {{ auth()->user()->company->company_name }}
                            </span>
                            @if (@Auth::user()->joining_date)
                                <span class="text-secondary font-size-80">
                                    Joined {{ date('d M, Y', strtotime(@Auth::user()->joining_date)) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('staff.profile', 'official') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-user mr-3">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('notification.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-bell mr-3">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        Notifications
                    </a>
                    <a class="dropdown-item" href="{{ route('staff.staffProfileEditView','security') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-settings mr-3">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                        Settings
                    </a>
                    {{-- <div class="dropdown-divider"></div> --}}
                    <a class="dropdown-item" href="{{ route('dashboard.logout') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-log-out mr-3">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Log out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white"> Take a break!</h5>
                <button type="button" class="close text-white" onclick="modalClose(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-5">
                    <div class="col-md-12">
                        <form action="{{ route('admin.dashboardBreakStart') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                {{ Form::label('amount', 'Reason', ['class' => 'form-label required']) }}
                                <textarea name="reason" class="form-control" required rows="3" placeholder="Enter Reason"></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary pull-right"><b>{{ _translate('Submit') }}</b></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="text" hidden id="default_lat" value="{{ settings('default_latitude')??40.7127753 }}">
<input type="text" hidden id="default_lng" value="{{ settings('default_longitude')??-74.0059728 }}">
<input type="text" hidden id="default_zoom" value="{{ settings('zoom')??12 }}">
<input type="text" hidden value="{{ route('ajax.chengeStatus') }}" id="chengeStatus_url">
<input type="text" hidden value="{{ route('updateUserIp') }}" id="updateUserIp">
