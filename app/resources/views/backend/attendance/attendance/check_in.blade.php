@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ @$data['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard') }}">{{ _trans('common.Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <div class="float-right mb-3  text-right">
                                            @if (hasPermission('attendance_read'))
                                                <a href="{{ route('attendance.index') }}" class="btn btn-primary">Attendance
                                                    List</a>
                                            @endif
                                        </div>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->


                                <form action="{{ route('attendance.store') }}" enctype="multipart/form-data" method="post"
                                    id="attendanceForm">
                                    @csrf
                                    <input type="text" hidden name="check_in_latitude" id="check_in_latitude">
                                    <input type="text" hidden name="check_in_longitude" id="check_in_longitude">
                                    <input type="text" hidden name="attendance_from" value="web">
                                    <div class="row">
                                        @if (auth()->user()->role->name == 'Staff')
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="" class="cus-label">Select Employee</label>
                                                    <select name="user_id" class="form-control" required="required">
                                                        <option selected value="{{ auth()->id() }}">
                                                            {{ auth()->user()->name }}</option>
                                                    </select>
                                                    @if ($errors->has('user_id'))
                                                        <div class="error">{{ $errors->first('user_id') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="" class="cus-label">Select Employees</label>
                                                    <select name="user_id" class="form-control" id="user_id">

                                                    </select>
                                                    @if ($errors->has('user_id'))
                                                        <div class="error">{{ $errors->first('user_id') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">Date</label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ old('date') }}" required>
                                                @if ($errors->has('date'))
                                                    <div class="error">{{ $errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header">
                                        <h5>Check in</h5>
                                    </div>
                                    <div class="row">


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Time</label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control" name="check_in"
                                                        value="{{ old('check_in') }}" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>

                                                @if ($errors->has('check_in'))
                                                    <div class="error">{{ $errors->first('check_in') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Location</label>
                                                <input type="text" name="check_in_location" class="form-control"
                                                    placeholder="Check in location" value="{{ old('check_in_location') }}"
                                                    required>
                                                @if ($errors->has('check_in_location'))
                                                    <div class="error">{{ $errors->first('check_in_location') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Late in reason</label>
                                                <textarea type="text" name="reason" class="form-control" placeholder="Check in reason">{{ old('reason') }}</textarea>
                                                @if ($errors->has('reason'))
                                                    <div class="error">{{ $errors->first('reason') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header">
                                        <h4>Check out</h4>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Time</label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control" name="check_out"
                                                        value="{{ old('check_out') }}">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>

                                                @if ($errors->has('check_out'))
                                                    <div class="error">{{ $errors->first('check_out') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" name="check_out_location" class="form-control"
                                                    placeholder="Check out location"
                                                    value="{{ old('check_out_location') }}">
                                                @if ($errors->has('check_out_location'))
                                                    <div class="error">{{ $errors->first('check_out_location') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Early leave reason</label>
                                                <textarea type="text" name="early_leave_reason" class="form-control" placeholder="Check out reason">{{ old('early_leave_reason') }}</textarea>
                                                @if ($errors->has('early_leave_reason'))
                                                    <div class="error">{{ $errors->first('early_leave_reason') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row  mt-20">
                                        <div class="col-md-12">
                                            <div class="text-right">
                                                <button class="btn btn-primary">{{ _trans('common.Submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
@section('script') 
<script src="{{url('public/backend/js/__location_get.js')}}"></script>
@endsection
