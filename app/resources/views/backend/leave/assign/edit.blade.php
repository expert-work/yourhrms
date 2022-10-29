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
                        <div class="col-md-12">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('assignLeave.update', $data['show']->id) }}"
                                class="card" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <div class="col-md-7 mx-auto">
                                                <div class="float-right mb-3  text-right">
                                                    @if (hasPermission('leave_assign_read'))
                                                    <a href="{{ route('assignLeave.index') }}"
                                                        class="btn btn-primary float-right float-left-sm-device"> <i
                                                            class="fa fa-arrow-left"></i> {{ _trans('common.Back') }}</a>
                                                @endif
                                                </div>
                                            </div>
                                        </div><!-- /.col -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7 mx-auto">
                                                <div class="form-group">
                                                    <label for="name" class="cus-label">{{ _trans('common.Days') }}</label>
                                                    <input type="number" name="days" class="form-control" placeholder="{{ _trans('common.Days') }}"
                                                        value="{{ $data['show']->days }}" required>
                                                    @if ($errors->has('days'))
                                                        <div class="error">{{ $errors->first('days') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-7 mx-auto">
                                                <div class="form-group">
                                                    <label for="name" class="cus-label">{{ _trans('common.Department') }}</label>
                                                    <select name="department_id" class="form-control" required="required">
                                                        <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                                        @foreach ($data['departments'] as $department)
                                                            <option value="{{ $department->id }}"
                                                                {{ $data['show']->department_id == $department->id ? 'selected' : '' }}>
                                                                {{ $department->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('department_id'))
                                                        <div class="error">{{ $errors->first('department_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-7 mx-auto">
                                                <div class="form-group">
                                                    <label for="name" class="cus-label">{{ _trans('leave.Leave type') }}</label>
                                                    <select name="type_id" class="form-control" required="required">
                                                        <option value="" disabled selected>{{ _trans('common.Choose One') }}
                                                        </option>
                                                        @foreach ($data['leaveTypes'] as $type)
                                                            <option value="{{ $type->id }}"
                                                                {{ $data['show']->type_id == $type->id ? 'selected' : '' }}>
                                                                {{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('type_id'))
                                                        <div class="error">{{ $errors->first('type_id') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-7 mx-auto">
                                                <div class="form-group">
                                                    <label for="name">{{ _trans('common.Status') }} <span
                                                            class="text-danger">*</span></label>
                                                    <select name="status_id" class="form-control" required>
                                                        <option value="" disabled selected>{{ _trans('common.Choose One') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ $data['show']->status_id == 1 ? 'selected' : '' }}>
                                                            {{ _translate('Active') }}</option>
                                                        <option value="2"
                                                            {{ $data['show']->status_id == 2 ? 'selected' : '' }}>
                                                            {{ _translate('In-active') }}</option>
                                                    </select>
                                                    @if ($errors->has('status_id'))
                                                        <div class="error">{{ $errors->first('status_id') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-7 mx-auto">
                                                <div class=" float-right mb-3  text-right">
                                                    @if (hasPermission('leave_assign_update'))
                                                        <button type="submit"
                                                            class="btn btn-primary action-btn">{{ _trans('common.Update') }}</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
