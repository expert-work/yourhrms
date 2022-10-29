@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
<div class="content-wrapper cus-content-wrapper">


    <!-- Main content -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="">
                <div class="vertical-tab">
                    <div class="row no-gutters mt-4">
                        <div class="col-md-12 pl-md-3 pt-md-0 pt-sm-4 pt-4">
                            <div class="card card-with-shadow border-0">
                                <div class="tab-content px-primary">
                                    <div id="General" class="tab-pane active  ">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                                {{ $data['title'] }} </h5>
                                        </div>
                                        <hr>
                                        <div class="content py-primary">
                                            <div props="[object Object]" id="General-0">
                                                <form action="{{ route('company.settings.update') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Date and time setting') }}
                                                            </legend>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.TimeZone') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div><select id="timezone" name="timezone"
                                                                                class="custom-select">
                                                                                @foreach ($data['timezones'] as $key =>
                                                                                $timezone)
                                                                                <option
                                                                                    value="{{ $timezone->time_zone }}"
                                                                                    {{
                                                                                    @$data['configs']['timezone']==$timezone->
                                                                                    time_zone ? 'selected'
                                                                                    :'' }}>
                                                                                    {{ $timezone->time_zone }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Date format') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select id="date_format" name="date_format"
                                                                                class="custom-select"
                                                                                style="background-image: url(&quot;https://pipex.gainhq.com/images/chevron-down.svg&quot;);">

                                                                                @foreach ($data['date_formats'] as
                                                                                $date_format)
                                                                                <option {{
                                                                                    @$data['configs']['date_format']==$date_format->
                                                                                    format ? 'selected' :'' }} value="{{
                                                                                    $date_format->format }}">{{
                                                                                    $date_format->normal_view }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Language setting') }}
                                                            </legend>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Select Language') }} 
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select name="lang" id="language"
                                                                                class="form-control">
                                                                                <option value="">{{
                                                                                    _trans('common.Select') }} {{
                                                                                    _trans('settings.Language') }}
                                                                                </option>
                                                                                @foreach($data['hrm_languages'] as
                                                                                $language)
                                                                                <option
                                                                                    value="{{ $language->language->code }}"
                                                                                    {{
                                                                                    @$data['configs']['lang']===$language->
                                                                                    language->code ? 'selected' :''
                                                                                    }}>{{ $language->language->name }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($errors->has('lang'))
                                                                            <div class="error">{{ $errors->first('lang')
                                                                                }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Attendance setting') }}
                                                            </legend>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Attendance Method') }} <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select name="attendance_method" class="form-control">
                                                                                <option value="{{ App\Enums\AttendanceMethod::NORMAL }}" {{ @$data['configs']['attendance_method']==App\Enums\AttendanceMethod::NORMAL?'selected':''  }}>{{ _trans('attendance.Normal') }}</option>
                                                                                <option value="{{ App\Enums\AttendanceMethod::FACE_RECOGNITION }}" 
                                                                                    {{ @$data['configs']['attendance_method']==App\Enums\AttendanceMethod::FACE_RECOGNITION?'selected':''  }}>
                                                                                    {{ _trans('attendance.Face Recognition') }}
                                                                                    <span class="badge badge-info">({{ _trans('common.Premium') }}</span>)</span>

                                                                                </option>
                                                                              <option value="{{ App\Enums\AttendanceMethod::QRCODE }}" {{
                                                                                    @$data['configs']['attendance_method']==App\Enums\AttendanceMethod::QRCODE?'selected':'' }}>
                                                                                    {{ _trans('attendance.QRCODE') }}
                                                                                    <span class="badge badge-info">({{ _trans('common.Premium') }})</span>
                                                                                </option>
                                                                                
                                                                            </select>
                                                                            @if ($errors->has('attendance_method'))
                                                                            <div class="error">{{ $errors->first('attendance_method')
                                                                                }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Login Method') }} <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select name="login_method" class="form-control">
                                                                                <option {{ @$data['configs']['login_method']=='password' ?'selected':'' }} value="password">{{
                                                                                    _trans('attendance.Password') }}</option>
                                                                                <option {{ @$data['configs']['login_method']=='pin' ?'selected':'' }} value="pin">{{
                                                                                    _trans('common.Pin') }}</option>
                                                                            </select>
                                                                            @if ($errors->has('login_method'))
                                                                            <div class="error">{{ $errors->first('login_method')
                                                                                }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Max Work Hours') }} <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                           <input type="text" class="form-control" name="max_work_hours" value="{{ @$data['configs']['max_work_hours'] ? @$data['configs']['max_work_hours'] : 16 }}"
                                                                                placeholder="{{ _trans('settings.Max Work Hours') }}" autocomplete="off">
                                                                            @if ($errors->has('max_work_hours'))
                                                                            <div class="error">{{ $errors->first('max_work_hours')
                                                                                }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Live tracking setting') }}
                                                            </legend>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.App sync time') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div data-toggle="buttons"
                                                                                    class="btn-group btn-group-toggle">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="app_sync_time"
                                                                                        value="{{ @$data['configs']['app_sync_time'] }}"
                                                                                        placeholder="{{ _trans('settings.App sync time') }}"
                                                                                        autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Live data store after') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div data-toggle="buttons"
                                                                                    class="btn-group btn-group-toggle">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="live_data_store_time"
                                                                                        value="{{ @$data['configs']['live_data_store_time'] }}"
                                                                                        placeholder="{{ _trans('settings.Live data store time') }}"
                                                                                        autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Api Key') }}
                                                            </legend>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Google Map Key') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <input type="text" class="form-control" name="google" value="{{ @$data['configs']['google'] }}"
                                                                                placeholder="{{ _trans('settings.Google Map Key') }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Google Firebase Key') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <input type="text" class="form-control" name="firebase" value="{{ @$data['configs']['firebase'] }}"
                                                                                placeholder="{{ _trans('settings.Google Firebase Key') }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.FCM TOPIC') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <input type="text" class="form-control" name="fcm_topic" value="{{ @$data['configs']['fcm_topic'] }}"
                                                                                placeholder="{{ _trans('settings.FCM TOPIC') }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Map Setup') }}
                                                            </legend>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Default Latitude ') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <input type="text" class="form-control" name="default_latitude" value="{{ @$data['configs']['default_latitude'] }}"
                                                                                placeholder="{{ _trans('settings.Default Latitude ') }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Default Longitude ') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <input type="text" class="form-control" name="default_longitude" value="{{ @$data['configs']['default_longitude'] }}"
                                                                                placeholder="{{ _trans('settings.Default Longitude ') }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Zoom') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <input type="text" class="form-control" name="zoom" value="{{ @$data['configs']['zoom'] }}"
                                                                                placeholder="{{ _trans('settings.Zoom') }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Permission Setup') }}
                                                            </legend>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Sync Permissions') }}
                                                                    </label>
                                                                    <div class="col-sm-3">
                                                                        <a href="{{ route('permission.update') }}"  class="btn btn-primary mb-2 mr-2"> <i class="fa fa-sync"></i> {{ _trans('settings.Sync Permissions') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <legend
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Currency setting') }}
                                                            </legend>
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Currency') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-3">
                                                                        <div><select id="select_currency_symbol"
                                                                                name="currency" class="custom-select"
                                                                                style="background-image: url(&quot;https://pipex.gainhq.com/images/chevron-down.svg&quot;);">
                                                                                @foreach ($data['currencies'] as $key =>
                                                                                $currency)
                                                                                <option value="{{ $currency->id }}" {{
                                                                                    @$data['configs']['currency']==$currency->
                                                                                    id ? 'selected' :'' }}>
                                                                                    {{ $currency->name }}
                                                                                </option>

                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="currency_symbol"
                                                                            value="{{ @$data['configs']['currency_symbol']}}"
                                                                            readonly class="form-control"
                                                                            id="currency_symbol">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="currency_code"
                                                                            value="{{ @$data['configs']['currency_code']}}"
                                                                            readonly class="form-control"
                                                                            id="currency_code">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                               
                                                    <div>
                                                        @if(hasPermission('company_settings_update'))
                                                        <button class="btn btn-primary mr-2"><span class="w-100">
                                                            </span> {{ _trans('common.Save') }}
                                                        </button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="currencyInfo" value="{{ route('company.settings.currencyInfo') }}">
@endsection
@section('script')
<script src="{{url('public/backend/js/image_preview.js')}}"></script>
@endsection