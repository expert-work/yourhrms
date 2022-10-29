<div class="col-lg-12 col-xl-3">
    <div class="card card-primary card-outline">
        <div class="card-body ">
            <div class="dashboard-side-card-img mr-2 text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ uploaded_asset($data['user']->avatar_id) }}"
                    alt="User profile picture">
            </div>
            <div class="media-body user-info-header mt-3">
                {{-- <span class="badge badge-sm badge-pill badge-success">Driver</span> --}}
                <div
                    class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center text-muted ">
                    <i class="fa fa-user"></i>
                    <p class="mb-0 text-break ml-2">
                        {{ $data['user']->name }}
                    </p>
                    </div>
                </div>
                <div
                    class="d-flex justify-content-center text-muted mt-2">
                    <i class="fa fa-envelope"></i>
                    <p class="mb-0 text-break ml-2">
                        {{ $data['user']->email }}
                    </p>
                </div>
                <div
                    class="d-flex justify-content-center text-muted mt-2">
                    <i class="fa fa-phone"></i>
                    <p class="mb-0 ml-2">
                        {{ $data['user']->phone }}
                    </p>
                </div>

                <div
                    class="d-flex justify-content-center text-muted mt-2">
                        @if(@$data['user']->driver->status_id == 1)
                            <button class="btn btn-secondary" onclick="GlobalApproveId('{{$data['user']->id}}',`dashboard/drivers/approve/`,'Deactivate');">
                                    {{_translate('Deactivate')}}
                        @else
                            <button class="btn btn-success" onclick="GlobalApproveId('{{$data['user']->id}}',`dashboard/drivers/approve/`,'Approve');">
                                    {{_translate('Approve')}}
                        @endif
                    </button>
                </div>

            </div>
        </div>
        <!-- /.card -->

        <div class="ltn__tab-menu-list">
            <div class="nav">
                <a class="show {{menu_active_by_route('driver.dashboard')}}" href="{{ route('driver.dashboard',encrypt($data['user']->id)) }}">{{ _trans('common.Dashboard') }} <i
                        class="fas fa-home"></i></a>
                {{-- <a class="" href="{{ route('drivers.report',encrypt($data['user']->id)) }}">Reports
                    <i class="fas fa-file-alt"></i></a> --}}
                <a class="{{menu_active_by_route('drivers.report')}}" href="{{ route('drivers.report',encrypt($data['user']->id)) }}">{{_translate('Reports')}}
                    <i class="fas fa-file-alt"></i></a>

                {{-- <a class="" href="{{ route('driver.monthlyStatement',encrypt($data['user']->id)) }}">Monthly Statement
                    <i class="fas fa-file-alt"></i></a> --}}
                <a class="{{menu_active_by_route('driver.driverList')}}" href="{{ route('driver.driverList',encrypt($data['user']->id)) }}">{{_translate('Driver List')}} <i
                        class="fas fa-id-card"></i></a>
                <a class="{{menu_active_by_route('driver.vehicles')}}" href="{{ route('driver.vehicles',encrypt($data['user']->id)) }}">{{_translate('Vehicle List')}} <i
                        class="fas fa-car-alt"></i></a>
                @if (@$data['user']->author->created_by == $data['user']->id)
                    <a class="{{menu_active_by_route('driver.payment')}}" href="{{ route('driver.payment',encrypt($data['user']->id)) }}">{{_translate('Payment')}}
                        <i class="fas fa-money-bill-wave"></i></a>
                @endif

                {{-- <a class="" href="{{ route('driver.profileView',encrypt($data['user']->id)) }}">Profile <i
                        class="fas fa-user"></i></a> --}}
                {{-- <a class="" data-toggle="accountSetting" href="#package">Packages <i--}} {{--
                        class="fas fa-arrow-down"></i></a>--}}
                <a class="{{menu_active_by_route('driver.accountSetting')}}" href="{{ route('driver.accountSetting',encrypt($data['user']->id)) }}">{{_translate('Settings')}}<i
                        class="fas fa-user-cog"></i></a>
                        <a class="{{menu_active_by_route('driver.changePassword')}}" href="{{ route('driver.changePassword',encrypt($data['user']->id)) }}">{{_translate('Change Password')}}
                            <i class="fas fa-file-alt"></i></a>

                @if (@$data['user']->author->created_by != $data['user']->id)
                    <a class="{{menu_active_by_route('driver.make_paren')}}" href="{{ route('driver.make_parent',encrypt($data['user']->id)) }}">{{_translate('Promote as Independent')}}
                        <i class="fas fa-user"></i></a>
                @endif

                <a href="{{ route('driver.loginAsDriver',encrypt($data['user']->id)) }}">
                    {{_translate('Login as  Driver')}}
                    <i class="fas fa-sign-out-alt"></i>
                </a>

                {{-- <form id="logout-form" action="http://adgari.test/logout" method="POST" class="d-none">
                    <input type="hidden" name="_token" value="q8cRwkz0ISdTihhBwjuL6YgZhA17yWlR8SED56PX">
                </form> --}}

            </div>
        </div>
    </div>
</div>
