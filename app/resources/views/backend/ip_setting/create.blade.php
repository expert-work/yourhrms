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
        <section class="content ">
            <div class="container-fluid ">
                <div class="row ">

                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('ipConfig.store') }}" class="card"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-10">

                                    <div class="col-12">
                                            <a href="{{ route('ipConfig.index') }}" class="btn btn-primary float-right ">
                                                <i class="fa fa-arrow-left"></i> Back</a>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">Location<span class="text-danger">*</span></label>
                                            <input type="text" name="location" class="form-control" placeholder="Location"
                                                value="{{ old('location') }}" required>
                                            @if ($errors->has('location'))
                                                <div class="error">{{ $errors->first('location') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">IP Address <span class="text-danger">*</span></label>
                                            <input type="text" name="ip_address" class="form-control"
                                                placeholder="IP Address" value="{{ old('ip_address') }}" required>
                                            @if ($errors->has('ip_address'))
                                                <div class="error">{{ $errors->first('ip_address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="area">{{ _trans('common.Status') }} <span class="text-danger">*</span></label>
                                            <select name="status_id" class="form-control" required>
                                                <option value="1" selected>{{ _trans('common.Active') }}</option>
                                               <option value="4">{{ _trans('common.In-active') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="is_office">{{ _trans('common.Is Office')  }} <span class="text-danger">*</span></label>
                                            <select name="is_office" id="is_office" class="form-control" required>
                                                <option value="33" selected>{{ _trans('common.Yes') }}</option>
                                                <option value="22">{{ _trans('common.No') }}</option>
                                            </select>
                                            <span class="status_error"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn  btn-primary ">Save</button>
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
