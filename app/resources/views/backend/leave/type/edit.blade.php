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
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-md-2"></div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('leave.update',$data['show']->id) }}"
                              class="card" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <div class="col-md-7 mx-auto">
                                            <div class="float-right mb-3  text-right">
                                                <a href="{{ route('leave.index') }}" class="btn btn-primary" >{{ _trans('common.Back') }}</a>
                                            </div>
                                        </div><!-- /.col -->

                                    </div>
                                </div><!-- /.row -->

                                <div class="row">
                                    <div class="col-md-7 mx-auto">
                                        <div class="form-group">
                                            <label for="name">Name<span
                                                        class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" placeholder="{{ _trans('common.Name') }}"
                                                   value="{{ $data['show']->name }}" required>
                                            @if ($errors->has('name'))
                                                <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7 mx-auto">
                                        <div class="form-group">
                                            <label for="name">Status<span
                                                        class="text-danger">*</span></label>
                                            <select name="status_id" class="form-control" required>
                                                <option value="" disabled
                                                        selected>{{ _trans('common.Choose One') }}
                                                </option>
                                                <option value="1" {{ $data['show']->status_id == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="2" {{ $data['show']->status_id == 2 ? 'selected' : '' }}>
                                                    In-active
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mx-auto">
                                        <div class=" float-right">
                                            @if(hasPermission('leave_type_update'))
                                                <button type="submit"
                                                        class="btn btn-primary action-btn">{{ _trans('common.Save') }}
                                                </button>
                                            @endif
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
