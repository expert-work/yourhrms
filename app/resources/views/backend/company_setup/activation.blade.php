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
                                            <h5
                                                class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
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
                                                            <div class="col-md-12">

                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Time format') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div data-toggle="buttons"
                                                                                    class="btn-group btn-group-toggle">
                                                                                    <label class="btn border"><input
                                                                                            type="radio"
                                                                                            name="time_format"
                                                                                            id="appSettings_time_format-0"
                                                                                            value="h" {{
                                                                                            @$data['configs']['time_format']==='h'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>
                                                                                            {{ _trans('settings.12
                                                                                            HOURS')
                                                                                            }}</span></label><label
                                                                                        class="btn border"><input
                                                                                            type="radio"
                                                                                            name="time_format"
                                                                                            id="appSettings_time_format-1"
                                                                                            value="H" {{
                                                                                            @$data['configs']['time_format']==='H'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>{{ _trans('settings.24
                                                                                            HOURS') }}</span></label>
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
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.IP Address Bind') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                @if (checkFeature('user_location_binds'))
                                                                                <a type="button" href="{{ route('ipConfig.UserWise') }}" class="btn btn-primary"><i class="bi bi-card-checklist"></i> {{ _trans('settings.User IP Bind') }}</a>
                                                                                @else 
                                                                                    <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                                                    
                                                                                        <label class="btn border"><input type="radio" name="ip_check" id="appSettings_ip_check-0" value="1" {{
                                                                                                @$data['configs']['ip_check']==='1' ? 'checked' : '' }}>
                                                                                            <span>{{ _trans('settings.Enable')}}</span>
                                                                                        </label>
                                                                                        <label class="btn border"><input type="radio" name="ip_check" id="appSettings_ip_check-1"
                                                                                                value="0" {{ @$data['configs']['ip_check']==='0' ? 'checked' : '' }}>
                                                                                            <span>{{_trans('settings.Disable')}}</span>
                                                                                        </label>
                                                                                    </div>
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Location Bind') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div data-toggle="buttons"
                                                                                    class="btn-group btn-group-toggle">

                                                                                    <label class="btn border"><input
                                                                                            type="radio"
                                                                                            name="location_check"
                                                                                            value="1" {{
                                                                                            @$data['configs']['location_check']==='1'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>{{
                                                                                            _trans('settings.Enable')
                                                                                            }}</span></label><label
                                                                                        class="btn border"><input
                                                                                            type="radio"
                                                                                            name="location_check"
                                                                                            value="0" {{
                                                                                            @$data['configs']['location_check']==='0'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>{{
                                                                                            _trans('settings.Disable')
                                                                                            }}</span></label>
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
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Multiple Check In & Check
                                                                        Out') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div data-toggle="buttons"
                                                                                    class="btn-group btn-group-toggle">

                                                                                    <label class="btn border"><input
                                                                                            type="radio"
                                                                                            name="multi_checkin"
                                                                                            id="appSettings_multi_checkin-0"
                                                                                            value="1" {{
                                                                                            @$data['configs']['multi_checkin']==='1'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>
                                                                                            {{ _trans('settings.Enable')
                                                                                            }}</span></label><label
                                                                                        class="btn border"><input
                                                                                            type="radio"
                                                                                            name="multi_checkin"
                                                                                            id="appSettings_multi_checkin-1"
                                                                                            value="0" {{
                                                                                            @$data['configs']['multi_checkin']==='0'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>
                                                                                            {{
                                                                                            _trans('settings.Disable')
                                                                                            }}</span></label>
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
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Live Tracking') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div data-toggle="buttons"
                                                                                    class="btn-group btn-group-toggle">
                                                                                    <label class="btn border"><input
                                                                                            type="radio"
                                                                                            name="location_service"
                                                                                            id="location_service-0"
                                                                                            value="1" {{
                                                                                            @$data['configs']['location_service']==='1'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>
                                                                                            {{ _trans('settings.Enable')
                                                                                            }}</span></label><label
                                                                                        class="btn border"><input
                                                                                            type="radio"
                                                                                            name="location_service"
                                                                                            id="location_service-1"
                                                                                            value="0" {{
                                                                                            @$data['configs']['location_service']==='0'
                                                                                            ? 'checked' : '' }}>
                                                                                        <span>
                                                                                            {{
                                                                                            _trans('settings.Disable')
                                                                                            }}</span></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <legend>
                                                            {{ _trans('attendance.Attendance Notification') }}
                                                        </legend>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('attendance.Admin Get Notification') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="radio-button-group">
                                                                            <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                                                <label class="btn border">
                                                                                    <input type="radio" name="admin_notify" id="admin_notify-0" value="1" {{
                                                                                        @$data['configs']['admin_notify']==='1' ? 'checked' : '' }}>
                                                                                    <span> {{ _trans('settings.Enable')}}</span>
                                                                                </label>
                                                                                <label class="btn border">
                                                                                    <input type="radio" name="admin_notify" id="admin_notify-1" value="0" {{
                                                                                        @$data['configs']['admin_notify']==='0' ? 'checked' : '' }}>
                                                                                    <span>{{_trans('settings.Disable')}}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('attendance.HR Get Notification') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="radio-button-group">
                                                                            <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                                                <label class="btn border">
                                                                                    <input type="radio" name="hr_notify" id="hr_notify-0" value="1" {{
                                                                                        @$data['configs']['hr_notify']==='1' ? 'checked' : '' }}>
                                                                                    <span> {{ _trans('settings.Enable')}}</span>
                                                                                </label>
                                                                                <label class="btn border">
                                                                                    <input type="radio" name="hr_notify" id="hr_notify-1" value="0" {{
                                                                                        @$data['configs']['hr_notify']==='0' ? 'checked' : '' }}>
                                                                                    <span>{{_trans('settings.Disable')}}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div>
                                                        @if (hasPermission('company_settings_update'))
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
<script src="{{ url('public/backend/js/image_preview.js') }}"></script>
@endsection