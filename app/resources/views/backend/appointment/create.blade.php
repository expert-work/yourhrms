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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
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
                    <div class="col-md-8">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('appointment.store') }}" class="card"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Title') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="{{ _translate('Enter Title') }}" value="{{ old('title') }}"
                                                required>
                                            @if ($errors->has('title'))
                                                <div class="error">{{ $errors->first('title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="cus-label">Description</label>
                                            <textarea name="description" class="form-control" placeholder="Enter Description" rows="6" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">{{ _translate('Location') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="location" class="form-control"
                                                placeholder="{{ _translate('location') }}"
                                                value="{{ old('location') }}" required>
                                            @if ($errors->has('location'))
                                                <div class="error">{{ $errors->first('location') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date" class="cus-label">Date Schedule</label>
                                            <input type="date" name="date" id="date" class="form-control"
                                                placeholder="Date" required>
                                            @if ($errors->has('date'))
                                                <div class="error">{{ $errors->first('date') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Appointment With</label>
                                            <select name="appoinment_with" class="form-control select2" id="user_id">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="" class="cus-label">Start Time</label>
                                            <input type="time" class="form-control" name="appoinment_start_at"
                                                value="{{ old('appoinment_start_at') }}" required>
                                            @if ($errors->has('appoinment_start_at'))
                                                <div class="error">{{ $errors->first('appoinment_start_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="" class="cus-label">End Time</label>
                                            <input type="time" class="form-control" name="appoinment_end_at"
                                                value="{{ old('appoinment_end_at') }}" required>
                                            @if ($errors->has('appoinment_end_at'))
                                                <div class="error">{{ $errors->first('appoinment_end_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">{{ _trans('common.Attachment') }}</label>
                                            <div>
                                                <div class="custom-image-upload-wrapper">
                                                    <div class="image-area d-flex">
                                                        <img id="bruh" src="{{ uploaded_asset(null) }}" alt=""
                                                            class="img-fluid mx-auto my-auto">
                                                    </div>
                                                    <div class="input-area"><label id="upload-label" for="upload_file">
                                                            {{ _trans('common.Documents file') }}
                                                        </label>
                                                        <input id="upload_file" name="attachment_file" type="file"
                                                            class="form-control d-none upload_file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col md-6 mt-130">
                                        <div class="card-footer float-right">
                                            <button type="submit"
                                                class="btn btn-primary action-btn">{{ _trans('common.Save') }}</button>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
    </div>
@endsection
