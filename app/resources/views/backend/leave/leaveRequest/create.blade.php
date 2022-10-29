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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('leaveRequest.store') }}"
                              class="card" enctype="multipart/form-data">
                            @csrf
                            <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label cus-label">Leave Type</label>
                                            <select class="form-control select2" name="assign_leave_id" required>
                                                <option value="" disabled
                                                        selected>{{ _trans('common.Choose One') }}
                                                </option>
                                                @foreach($data['leaveTypes'] as $type)
                                                    <option value="{{ $type->id }}">{{ $type->type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Substitute</label>
                                            <select name="substitute_id" class="form-control select2" id="user_id">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Leave from<span class="text-danger">*</span></label>
                                            <input class="daterange-table-filter" type="text" name="daterange" value="{{ date('m/d/Y') }}-{{ date('m/d/Y') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="cus-label">Reason</label>
                                            <textarea name="reason" class="form-control"
                                                      placeholder="Reason" rows="6" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
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
                                                    </label> <input
                                                            id="upload_file"
                                                            name="file"
                                                            type="file"
                                                            class="form-control d-none upload_file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer float-right">
                                <button type="submit" class="btn btn-primary action-btn ">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
    </div>
@endsection
