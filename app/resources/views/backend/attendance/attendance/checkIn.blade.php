@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ @$data['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="float-sm-right mb-3">
                            <a href="{{ route('dutySchedule.index') }}"
                               class="btn btn-primary">Schedule List</a>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <!-- Main content -->


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="offset-lg-2 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add New Attendance</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('attendance.store') }}" enctype="multipart/form-data"
                                      method="post" id="attendanceForm">
                                    @csrf
                                    @php
                                        $now =\Carbon\Carbon::now();
                                    @endphp
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Date</label>
                                                <input type="date" class="form-control" name="date"
                                                       value="{{ $now->format('mm/dd/yyyy') }}" required>
                                                @if ($errors->has('date'))
                                                    <div class="error">{{ $errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Select Employee</label>
                                                <select name="user_id" class="form-control" required="required">
                                                    <option value="" disabled
                                                            selected>{{ _trans('common.Choose One') }}
                                                    </option>
                                                    @foreach ($data['users'] as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('user_id'))
                                                    <div class="error">{{ $errors->first('user_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Check in location</label>
                                                <input type="text" name="check_in_location" class="form-control"
                                                       placeholder="Check in location"
                                                       value="{{ old('check_in_location') }}" required>
                                                @if ($errors->has('check_in_location'))
                                                    <div class="error">{{ $errors->first('check_in_location') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Check In</label>
                                                <input type="time" class="form-control" name="check_in"
                                                       value="{{ $now->format('g:i A') }}" required>
                                                @if ($errors->has('check_in'))
                                                    <div class="error">{{ $errors->first('check_in') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating">
                                                <label for="floatingTextarea2 cus-label">Late Reason</label>
                                                <textarea class="form-control leave-reasone-textbox {{ @$errors->has('late_reason') ? ' is-invalid' : '' }}" name="late_reason" placeholder="Leave reason here.." id="floatingTextarea2"></textarea>
                                                @if ($errors->has('late_reason'))
                                                     <span class="invalid-feedback" role="alert">
                                                     <strong>{{ @$errors->first('late_reason') }}</strong>
                                                    </span>
                                                @endif
                                              </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-3 mt-3">Check Out</h5>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Check Out location</label>
                                                <input type="text" name="check_out_location" class="form-control"
                                                       placeholder="Check in location"
                                                       value="{{ old('check_out_location') }}">
                                                @if ($errors->has('check_out_location'))
                                                    <div class="error">{{ $errors->first('check_out_location') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">Check out Time</label>
                                                <input type="time" class="form-control" name="check_out"
                                                       value="{{ $now->format('g:i A') }}">
                                                @if ($errors->has('check_out'))
                                                    <div class="error">{{ $errors->first('check_out') }}</div>
                                                @endif
                                            </div>
                                        </div>



                                    </div>

                                    <div class="row  mt-20">
                                        <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">{{ _trans('common.Status') }}</button>
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
@endsection
