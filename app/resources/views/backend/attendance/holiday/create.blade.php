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
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('holidaySetup.store')}}" class="form-validate" method="POST" enctype="multipart/form-data"> 
                    @csrf
                    <div class="card">

                       <div class="card-body">
                            <div class="row mb-10">
                               <div class="col-md-12">
                                    <div class="float-right mb-3  text-right">

                                        <a href="{{ route('holidaySetup.index') }}" class="btn btn-primary" >{{ _trans('leave.Holiday List') }}</a>
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="title" class="cus-label">{{ _trans('common.Title') }}</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="{{ _trans('common.Title') }}" required>
                                        @if ($errors->has('title'))
                                            <div class="error">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="start_date" class="cus-label">{{ _trans('common.Start Date') }}</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" placeholder="{{ _trans('common.Start Date') }}" required>
                                        @if ($errors->has('start_date'))
                                            <div class="error">{{ $errors->first('start_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="end_date" class="cus-label">{{ _trans('common.End Date') }}</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="{{ _trans('common.End Date') }}" required>
                                        @if ($errors->has('end_date'))
                                            <div class="error">{{ $errors->first('end_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description" class="cus-label">{{ _trans('common.Description') }}</label>
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="{{ _trans('common.Description') }}" required></textarea>
                                        @if ($errors->has('description'))
                                            <div class="error">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="status">{{ _trans('common.Attachment') }}</label>
                                        <div>
                                            <div class="custom-image-upload-wrapper">
                                                <div class="image-area d-flex">
                                                    <img id="bruh" src="{{ uploaded_asset(null) }}" alt=""
                                                         class="img-fluid mx-auto my-auto">
                                                </div>
                                                <div class="input-area"><label
                                                            id="upload-label"
                                                            for="upload_file">
                                                        {{ _trans('common.Documents file') }}
                                                    </label>
                                                    <input id="upload_file" name="file" type="file" class="form-control d-none upload_file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    {{-- status --}}
                                    <div class="form-group">
                                        <label for="status">{{ _trans('common.Status') }}</label>
                                        <select name="status_id" class="form-control select2" required="required">
                                            <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                            <option value="1" selected>{{ _trans('common.Active') }}</option>
                                           <option value="2">{{ _trans('common.In-active') }}</option>
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
                                            <button class="btn btn-primary">{{ _trans('common.Submit') }}</button>
                                        </div>
                                </div>
                            </div>
                       </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('script')
@endsection

