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
                                    href="{{ route('admin.dashboard') }}">{{ _translate('Dashboard') }}</a></li>
                            @if (hasPermission('company_setup_location'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('company.settings.location') }}">{{ _trans('common.List') }}</a>
                                </li>
                            @endif
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
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">{{ _trans('settings.Distance') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="distance" class="form-control"
                                                value="{{ old('distance') }}" required placeholder="0">
                                                <small> {{ _trans('settings.Distance measure in meters') }}</small>
                                            @if ($errors->has('distance'))
                                                <div class="error">{{ $errors->first('distance') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group" id="_st">
                                            <label for="area">{{ _trans('common.Status') }} <span class="text-danger">*</span></label>
                                            <select id="status_id" class="form-control" required>
                                                <option value="1" selected>{{ _trans('common.Active') }}</option>
                                                <option value="4">{{ _trans('common.In-active') }}</option>
                                            </select>
                                            <span class="status_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group" id="_st">
                                            <label for="is_office">{{ _trans('common.Is Office')  }} <span class="text-danger">*</span></label>
                                            <select id="is_office" class="form-control" required>
                                                <option value="33" selected>{{ _trans('common.Yes') }}</option>
                                                <option value="22">{{ _trans('common.No') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">
                                                {{ _trans('settings.Location') }} <span class="text-danger">*</span>
                                                <span  class="btn btn-primary" id="detectLocation" data-toggle="locationPickerStore">
                                                    <i class="fa fa-map-marker"></i> 
                                                    {{ _trans('common.Auto Detect') }}
                                                    </span>
                                                    
                                            </label>
                                            <div class="col-md-6 d-none" id="location_input">
                                                <input id="pac-input" class="form-control controls location" type="text"
                                                    placeholder="Enter a location" required name="location"  onkeydown="return (event.keyCode!=13);" />
                                            </div>
                                            <div class="row dataTable-btButtons">
                                                <div class="col-lg-12">
                                                    <div class="ltn__map-area">
                                                        <div class="ltn__map-inner">
                                                            <div id="map" style="height: 500px;"></div>
                                                            <div class="mt-5" id="directions_panel"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @if (@$data['url'])
                                    <div class="row  mt-20">
                                        <div class="col-md-12">
                                            <div class="text-right">
                                                <button class="btn btn-primary" onTouch="locationPickerStore(`{{ $data['url'] }}`)" onClick="locationPickerStore(`{{ $data['url'] }}`)">{{ _trans('common.Save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="latitude" value="{{ @$data['location']->latitude ?? 40.7127753 }}">
        <input type="hidden" id="longitude" value="{{ @$data['location']->longitude ?? -74.0059728 }}">
    </div>
@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key={{ @settings('google') }}">
    </script>
    <script src="{{ asset('public/backend/js/__location_find.js') }}"></script>
@endsection
