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
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('content.update', $data['show']->id) }}"
                            class="card" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="department_id" value="{{ $data['show']->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Title<span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="{{ _trans('common.Title') }}"
                                                value="{{ $data['show']->title }}" required>
                                            @if ($errors->has('title'))
                                                <div class="error">{{ $errors->first('title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Content<span class="text-danger">*</span></label>
                                            <textarea class="form-control en" name="content" rows="10">{{ $data['show']->content }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Meta Title<span class="text-danger">*</span></label>
                                            <input type="text" name="meta_title" class="form-control"
                                                placeholder="Meta Title" value="{{ $data['show']->meta_title }}"
                                                required>
                                            @if ($errors->has('meta_title'))
                                                <div class="error">{{ $errors->first('meta_title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Meta Description<span class="text-danger">*</span></label>
                                            <textarea class="form-control en" name="meta_description" rows="10">{{ $data['show']->meta_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Keywords<span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" placeholder="Keywords"
                                                value="{{ $data['show']->keywords }}" required>
                                            @if ($errors->has('keywords'))
                                                <div class="error">{{ $errors->first('keywords') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="image" class="col-sm-2 col-form-label">Meta Image</label>
                                            <div class="col-sm-10">
                                                <div>
                                                    @php
                                                        // dd($data['show']->meta_image);
                                                    @endphp
                                                    <div class="custom-image-upload-wrapper">
                                                        <div class="image-area d-flex">
                                                            <img id="bruh"
                                                                src="{{ uploaded_asset($data['show']->meta_image) }}"
                                                                alt="" class="img-fluid mx-auto my-auto">
                                                        </div>
                                                        <div class="input-area"><label id="upload-label"
                                                                for="appSettings_company_logo">
                                                                Change Meta Image
                                                            </label> <input id="appSettings_company_logo" name="meta_image"
                                                                type="file" class="form-control d-none">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- @if (@$data['show']->meta_image)
                                                <img src="{{ uploaded_asset($data['show']->meta_image) }}" alt=""
                                                     width="80" srcset="">
                                            @endif --}}
                                            @error('meta_image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col md-12">
                                        <div class="card-footer float-right">
                                            <button type="submit" class="btn btn-primary action-btn">Update</button>
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
@section('style')
    {{-- iziToast cdn --}}
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/iziToast.css') }}">
@endsection
@section('script')
    {{-- iziToast cdn --}}
    <script src="{{ asset('public/frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ asset('public/backend/js/image_preview.js') }}"></script>
    <script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/ckeditor/config.js') }}"></script>
    <script src="{{ asset('public/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('public/ckeditor/build-config.js') }}"></script>
    <script src="{{ asset('public/backend/js/global_ckeditor.js') }}"></script>

@endsection
