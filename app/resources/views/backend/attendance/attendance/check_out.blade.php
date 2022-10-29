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
                    <div class=" col-lg-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <div class="float-right mb-3  text-right">
                                            <a href="{{ route('attendance.index') }}"
                                               class="btn btn-primary">{{ _trans('attendance.Attendance list') }}</a>
                                        </div>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                                <form action="{{ route('attendance.update',$data['show']->id) }}"
                                      enctype="multipart/form-data"
                                      method="post" id="attendanceForm">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('attendance.Select Employee') }}</label>
                                                <select name="user_id" class="form-control" required="required">
                                                    <option value="" disabled
                                                            selected>{{ _trans('common.Choose One') }}
                                                    </option>
                                                    @foreach ($data['users'] as $user)
                                                        <option value="{{ $user->id }}" {{ $data['show']->user_id == $user->id ? 'selected' :''  }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('user_id'))
                                                    <div class="error">{{ $errors->first('user_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">Date</label>
                                                <input type="date" name="date" class="form-control"
                                                       value="{{ @$data['show']->date }}" required >
                                                @if ($errors->has('date'))
                                                    <div class="error">{{ $errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="">
                                        <h5>Check in</h5>
                                    </div>
                                    <div class="row">



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">In Time</label>
                                                <input type="time" class="form-control" name="check_in"
                                                       value="{{ \Carbon\Carbon::parse($data['show']->check_in)->format('H:i') }}"
                                                       required>
                                                @if ($errors->has('check_in'))
                                                    <div class="error">{{ $errors->first('check_in') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">location</label>
                                                <input type="text" name="check_in_location" class="form-control"
                                                       placeholder="Check in location"
                                                       value="{{ $data['show']->check_in_location }}" required>
                                                @if ($errors->has('check_in_location'))
                                                    <div class="error">{{ $errors->first('check_in_location') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Late reason</label>
                                                <textarea type="text" name="late_in_reason" class="form-control"
                                                       placeholder="Check in reason">{{ @$data['show']->lateInReason->reason }}</textarea>
                                                @if ($errors->has('late_in_reason'))
                                                    <div class="error">{{ $errors->first('late_in_reason') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="">
                                        <h5>Check out</h5>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">out time</label>
                                                <input type="time" class="form-control" name="check_out"
                                                       value="{{ $data['show']->check_out ? \Carbon\Carbon::parse($data['show']->check_out)->format('H:i') : '' }}"
                                                       required>
                                                @if ($errors->has('check_out'))
                                                    <div class="error">{{ $errors->first('check_out') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">location</label>
                                                <input type="text" name="check_out_location" class="form-control"
                                                       placeholder="Check in location"
                                                       value="{{ $data['show']->check_out_location }}" required>
                                                @if ($errors->has('check_out_location'))
                                                    <div class="error">{{ $errors->first('check_out_location') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Early leave reason</label>
                                                <textarea type="text" name="early_leave_reason" class="form-control"
                                                       placeholder="Check out location">{{ @$data['show']->earlyOutReason->reason }}</textarea>
                                                @if ($errors->has('early_leave_reason'))
                                                    <div class="error">{{ $errors->first('early_leave_reason') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row  mt-20">
                                        <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">Update</button>
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
