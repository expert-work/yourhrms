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
        <section class="content p-0">
            <div class="container-fluid border-radius-5 ">
                <div class="row">
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (url()->current()==route('client.create'))
                            <form method="POST" action="{{ route('client.store') }}" class="card" enctype="multipart/form-data">
                        @else
                            <form method="POST" action="{{ route('client.update') }}" class="card" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{ $data['show']->id }}">
                        @endif
                            
                            @csrf
                            <div class="card-body">
                                <div class="row mb-10 align-items-center">
                                    <div class="col-md-12">
                                        <div class="">
                                            <div class="float-right mb-3  text-right">
                                                <a href="{{ route('client.index') }}" class="btn btn-primary "> <i
                                                        class="fa fa-arrow-left"></i> Back</a>
                                            </div>
                                        </div><!-- /.col -->
                                    </div>
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Name') }}<span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="{{ _trans('common.Name') }}" value="{{ @$data['show'] ? $data['show']->name : old('name') }}" required>
                                            @if ($errors->has('name'))
                                                <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Email') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" placeholder="{{ _trans('common.Email') }}"
                                                value="{{ @$data['show'] ? $data['show']->email : old('email') }}" required>
                                            @if ($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Phone') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" placeholder="{{ _trans('common.Phone') }}"
                                                value="{{ @$data['show'] ? $data['show']->phone : old('phone') }}" required>
                                            @if ($errors->has('phone'))
                                                <div class="error">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('client.Website') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="website" class="form-control" placeholder="{{ _trans('common.Website') }}"
                                                value="{{ @$data['show'] ? $data['show']->website : old('website') }}" required>
                                            @if ($errors->has('website'))
                                                <div class="error">{{ $errors->first('website') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Address') }} </label>
                                            <input type="text" name="address" class="form-control" placeholder="{{ _trans('common.Address') }}"
                                                value="{{ @$data['show'] ? $data['show']->address : old('address') }}" >
                                            @if ($errors->has('address'))
                                                <div class="error">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.City') }} </label>
                                            <input type="text" name="city" class="form-control" placeholder="{{ _trans('common.City') }}"
                                                value="{{ @$data['show'] ? $data['show']->city : old('city') }}" >
                                            @if ($errors->has('city'))
                                                <div class="error">{{ $errors->first('city') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.State') }} </label>
                                            <input type="text" name="state" class="form-control" placeholder="{{ _trans('common.State') }}"
                                                value="{{ @$data['show'] ? $data['show']->state : old('state') }}" >
                                            @if ($errors->has('state'))
                                                <div class="error">{{ $errors->first('state') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Zip') }} </label>
                                            <input type="text" name="zip" class="form-control" placeholder="{{ _trans('common.Zip') }}"
                                                value="{{ @$data['show'] ? $data['show']->zip : old('zip') }}" >
                                            @if ($errors->has('zip'))
                                                <div class="error">{{ $errors->first('zip') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Country') }} </label>
                                            <select name="country_id" class="form-control select2" id="_country_id"  style="width: 100%">
                                                <option value="{{ @$data['show'] ? $data['show']->country :'' }}">{{ @$data['show'] ? @$data['show']->countryInfo->name :'' }}</option>
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <div class="error">{{ $errors->first('country_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('common.Status') }} <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" >
                                                <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                                <option value="1" {{ @$data['show'] ? $data['show']->status_id==1?'selected' : '':'' }}>Active</option>
                                                <option value="4" {{ @$data['show'] ? $data['show']->status_id==4?'selected' : '':'' }}>In-active</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="name">{{ _trans('common.Avater') }} </label>
                                        <div class="custom-image-upload-wrapper">
                                            <div class="image-area d-flex">
                                                <img id="uploaded_image_viewer" src="{{ uploaded_asset(@$data['show']->avater->file_id) }}" alt=""
                                                    class="img-fluid mx-auto my-auto">
                                            </div>
                                          <div class="input-area"><label id="upload-label" for="image_upload_input">
                                                    Change avatar
                                                </label> <input id="image_upload_input" name="avatar" type="file" class="form-control d-none">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary action-btn">
                                   {{ _trans('common.Save') }}
                                </button>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script src="{{url('public/backend/js/pages/__profile.js')}}"></script>
@endsection

