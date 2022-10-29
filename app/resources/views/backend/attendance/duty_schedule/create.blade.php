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
                                        href="{{ route('admin.dashboard') }}">{{_trans('common.Dashboard')}}</a></li>
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card box-shadow-none">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="float-right mb-3  text-right">
                                            <a href="{{ route('dutySchedule.index') }}" class="btn btn-primary">{{_trans('attendance.Schedule List')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('dutySchedule.store') }}" enctype="multipart/form-data"
                                    method="post" id="holidayModal">
                                    @csrf
                                    @php
                                        $now = \Carbon\Carbon::now();
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('common.Shift') }}</label>
                                                <select name="shift_id[]" class="form-control select2"
                                                        multiple="multiple" required="required">
                                                    <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                                    @foreach($data['shifts'] as $key => $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('shift_id'))
                                                    <div class="error">{{ $errors->first('shift_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{  _trans('attendance.Consider Time') }}</label>
                                                <input type="number" max="60" min="0" class="form-control"
                                                    name="consider_time" value="0">
                                                @if ($errors->has('consider_time'))
                                                    <div class="error">{{ $errors->first('consider_time') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{ _trans('common.Start Time') }}</label>
                                                <input type="time" class="form-control" name="start_time"
                                                       value="{{ $now->format('g:i A') }}" required>
                                                @if ($errors->has('start_time'))
                                                    <div class="error">{{ $errors->first('start_time') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{ _trans('common.End Time') }}</label>
                                                <input type="time" class="form-control" name="end_time"
                                                       value="{{ $now->format('g:i A') }}" required>
                                                @if ($errors->has('end_time'))
                                                    <div class="error">{{ $errors->first('end_time') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Schedule End') }}</label>
                                                <select name="end_on_same_date" class="form-control" required="required">
                                                    <option value="" disabled >{{ _trans('common.Choose One') }}
                                                    </option>
                                                    <option selected  value="1"> {{  _trans('common. Same Date') }}
                                                    </option>
                                                    <option value="0">{{  _trans('common.Next Date') }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('end_on_same_date'))
                                                    <div class="error">{{ $errors->first('end_on_same_date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Status') }}</label>
                                                <select name="status_id" class="form-control select2" required="required">
                                                    <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                                    <option value="1" selected>{{  _trans('common.Active') }}</option>
                                                    <option value="2">{{  _trans('common.In-active') }}</option>
                                                </select>
                                                @if ($errors->has('status_id'))
                                                    <div class="error">{{ $errors->first('status_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  mt-20">
                                        <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">{{ _trans('common.Save') }}</button>
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
@section('script')
    @include('backend.partials.datatable')
@endsection
