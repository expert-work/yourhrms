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
                        <form method="POST" action="{{ route('assignLeave.store') }}"
                              class="card" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <div class="col-md-7 mx-auto">
                                            <div class="float-right mb-3  text-right">
                                                @if(hasPermission('leave_assign_read'))
                                                    <a href="{{ route('assignLeave.index') }}" class="btn btn-primary "> <i class="fa fa-arrow-left pr-2"></i>  {{ _trans('common.Back') }}</a>
                                            @endif
                                            </div>
                                        </div><!-- /.col -->
                                    </div>
                                </div><!-- /.row -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-7 mx-auto">
                                            <div class="form-group">
                                                <label for="name" class="cus-label">{{ _trans('common.Days') }}</label>
                                                <input type="number" name="days" class="form-control" placeholder="{{ _trans('common.Days') }}"
                                                       value="{{ old('days') }}" required>
                                                @if ($errors->has('days'))
                                                    <div class="error">{{ $errors->first('days') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-7 mx-auto">
                                            <div class="form-group">
                                                <label for="name" class="cus-label">{{ _trans('common.Department') }}</label>
                                                <select name="department_id[]" class="form-control select2"
                                                        multiple="multiple" required="required">
                                                    <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                                    @foreach($data['departments'] as $key => $department)
                                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('department_id'))
                                                    <div class="error">{{ $errors->first('department_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-7 mx-auto">
                                            <div class="form-group">
                                                <label for="name" class="cus-label">{{ _trans('leave.Leave type') }}</label>
                                                <select name="type_id" class="form-control select2" required="required">
                                                    <option value="" disabled
                                                            selected>{{ _trans('common.Choose One') }}
                                                    </option>
                                                    @foreach($data['leaveTypes'] as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                                                <select name="status_id" class="form-control select2" required>
                                                    <option value="" disabled
                                                            selected>{{ _trans('common.Choose One') }}
                                                    </option>
                                                    <option value="1" selected>{{ _trans('common.Active') }}</option>
                                                   <option value="2">{{ _trans('common.In-active') }}</option>
                                                </select>
                                                @if ($errors->has('status_id'))
                                                    <div class="error">{{ $errors->first('status_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-7 mx-auto">
                                            <div class=" float-right">
                                                @if(hasPermission('leave_assign_create'))
                                                    <button type="submit"
                                                            class="btn btn-primary action-btn">{{ _trans('common.Save') }}
                                                    </button>
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


