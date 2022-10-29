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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{
                                _trans('common.Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row mb-10">

                                <div class=" col-12">
                                    <div class="float-sm-right mb-3  ">
                                        @if(hasPermission('notice_list'))
                                        <a href="{{ route('notice.index') }}" class="btn btn-primary "> <i
                                                class="fa fa-arrow-left pr-2"></i> {{ _trans('common.Back') }}</a>
                                        @endif
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <form action="{{ route('notice.sendPushNotification') }}" enctype="multipart/form-data" method="post"
                                id="attendanceForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Title') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="{{ _trans('common.Title') }}"
                                                value="{{ old('title') }}" required>
                                            @if ($errors->has('title'))
                                            <div class="error">{{ $errors->first('title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="cus-label">{{ _trans('common.Notify To') }}</label>
                                            <div class="radio-button-group">
                                                <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                    <label class="btn border">
                                                        <input type="radio" checked name="notification_type" id="admin_notify-0" value="1">
                                                        <span> {{ _trans('notice.Specific User')}}</span>
                                                    </label>
                                                    <label class="btn border">
                                                        <input type="radio" name="notification_type" id="admin_notify-1" value="0">
                                                        <span>{{_trans('common.All Users')}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('notification_type'))
                                            <div class="error">{{ $errors->first('notification_type') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="sepcific_user_section">
                                        <div class="form-group">
                                            <label for="name" class="cus-label">{{ _trans('common.Users')
                                                }}</label>
                                            <select name="users[]" class="form-control select2"
                                                multiple="multiple">
                                                <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                                @foreach($data['users'] as $key => $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('users'))
                                            <div class="error">{{ $errors->first('users') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="message" class="cus-label">{{ _trans('common.Message')
                                                }}</label>
                                            <textarea name="message" id="message" class="form-control" cols="30"
                                                rows="5" placeholder="{{ _trans('common.Message') }}"
                                                required></textarea>
                                            @if ($errors->has('message'))
                                            <div class="error">{{ $errors->first('message') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col md-6 mt-130">
                                        <div class="card-footer float-right">
                                            <button type="submit" class="btn btn-primary action-btn">{{
                                                _trans('common.Save') }}</button>
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