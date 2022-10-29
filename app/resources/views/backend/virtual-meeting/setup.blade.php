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
                            <div class="col-md-3 pr-md-3 tab-menu">
                                <div class="card card-with-shadow border-0">
                                    <div class="header-icon">
                                        <div class="icon-position d-flex justify-content-center">
                                            <div class="tab-icon d-flex justify-content-center align-items-center">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-settings">
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                    <path
                                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-primary py-primary">
                                        <div role="tablist" aria-orientation="vertical"
                                             class="nav flex-column nav-pills"><a
                                                href="{{ route('company.settings.view') }}"
                                                class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3 active"><span>{{ _trans('settings.Company Config') }}</span>
                                                <span class="active-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                               width="24" height="24"
                                                                               viewBox="0 0 24 24" fill="none"
                                                                               stroke="currentColor" stroke-width="2"
                                                                               stroke-linecap="round"
                                                                               stroke-linejoin="round"
                                                                               class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span></a>

                                        </div>
                                        <div role="tablist" aria-orientation="vertical"
                                             class="nav flex-column nav-pills"><a
                                                href="{{ route('company.settings.locationApi') }}"
                                                class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3"><span>{{ _trans('settings.API Setup') }}</span>
                                                <span class="active-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                               width="24" height="24"
                                                                               viewBox="0 0 24 24" fill="none"
                                                                               stroke="currentColor" stroke-width="2"
                                                                               stroke-linecap="round"
                                                                               stroke-linejoin="round"
                                                                               class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span></a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 pl-md-3 pt-md-0 pt-sm-4 pt-4">
                                <div class="card card-with-shadow border-0">
                                    <div class="tab-content px-primary">
                                        <div id="General" class="tab-pane active  ">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                                    Company Settings</h5>
                                                <div class="d-flex align-items-center mb-0">
                                                </div>
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
                                                                        </label>
                                                                        <div class="col-sm-4">
                                                                            <div><select id="timezone" name="timezone"
                                                                                         class="custom-select">
                                                                                    @foreach ($data['timezones'] as $key => $timezone)
                                                                                        <option
                                                                                            value="{{ $timezone->time_zone }}" {{ @$data['configs']['timezone']==$timezone->time_zone ? 'selected'
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
                                                                        </label>
                                                                        <div class="col-sm-4">
                                                                            <div>
                                                                                <select id="date_format"
                                                                                        name="date_format"
                                                                                        class="custom-select"
                                                                                        style="background-image: url(&quot;https://pipex.gainhq.com/images/chevron-down.svg&quot;);">

                                                                                    @foreach ($data['date_formats'] as $date_format)
                                                                                        <option
                                                                                            {{ @$data['configs']['date_format'] == $date_format->format ? 'selected' :'' }} value="{{ $date_format->format }}">{{ $date_format->normal_view }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                             {{ _trans('settings.Time format') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div class="radio-button-group">
                                                                                    <div data-toggle="buttons"
                                                                                         class="btn-group btn-group-toggle">
                                                                                        <label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="time_format"
                                                                                                id="appSettings_time_format-0"
                                                                                                value="h" {{ @$data['configs']['time_format'] === 'h' ? 'checked' :'' }}>
                                                                                            <span> {{ _trans('settings.12 HOURS') }}</span></label><label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="time_format"
                                                                                                id="appSettings_time_format-1"
                                                                                                value="H" {{ @$data['configs']['time_format'] === 'H' ? 'checked' :'' }}>
                                                                                            <span>{{ _trans('settings.24 HOURS') }}</span></label>
                                                                                    </div>
                                                                                </div>
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
                                                                            {{ _trans('settings.Select Language') }} <span
                                                                                class="text-danger">*</span>
                                                                        </label>
                                                                        <div class="col-sm-4">
                                                                            <div>
                                                                                <select name="lang" id="language"
                                                                                        class="form-control">
                                                                                    <option
                                                                                        value="">{{ _trans('common.Select') }} {{ _trans('settings.Language') }}</option>
                                                                                    @foreach($data['hrm_languages'] as $language)
                                                                                        <option
                                                                                            value="{{ $language->language->code }}" {{ @$data['configs']['lang'] ===  $language->language->code ? 'selected' :'' }}>{{ $language->language->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @if ($errors->has('lang'))
                                                                                    <div
                                                                                        class="error">{{ $errors->first('lang') }}</div>
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
                                                                      {{ _trans('settings.Wifi IP setting') }}
                                                                </legend>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                              {{ _trans('settings.IP Based Attendance') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div class="radio-button-group">
                                                                                    <div data-toggle="buttons"
                                                                                         class="btn-group btn-group-toggle">

                                                                                        <label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="ip_check"
                                                                                                id="appSettings_ip_check-0"
                                                                                                value="1" {{ @$data['configs']['ip_check'] === '1' ? 'checked' :'' }}>
                                                                                            <span>{{ _trans('settings.Enable') }}</span></label><label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="ip_check"
                                                                                                id="appSettings_ip_check-1"
                                                                                                value="0" {{ @$data['configs']['ip_check'] === '0' ? 'checked' :'' }}>
                                                                                            <span>{{ _trans('settings.Disable') }}</span></label>
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
                                                                     {{ _trans('settings.Attendance setting') }}
                                                                </legend>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                              {{ _trans('settings.Multiple Checkin/Checkout') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div class="radio-button-group">
                                                                                    <div data-toggle="buttons"
                                                                                         class="btn-group btn-group-toggle">

                                                                                        <label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="multi_checkin"
                                                                                                id="appSettings_multi_checkin-0"
                                                                                                value="1" {{ @$data['configs']['multi_checkin'] === '1' ? 'checked' :'' }}>
                                                                                            <span> {{ _trans('settings.Enable') }}</span></label><label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="multi_checkin"
                                                                                                id="appSettings_multi_checkin-1"
                                                                                                value="0" {{ @$data['configs']['multi_checkin'] === '0' ? 'checked' :'' }}>
                                                                                            <span> {{ _trans('settings.Disable') }}</span></label>
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
                                                                      {{ _trans('settings.Location Background') }}
                                                                </legend>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                              {{ _trans('settings.Location service') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div class="radio-button-group">
                                                                                    <div data-toggle="buttons"
                                                                                         class="btn-group btn-group-toggle">
                                                                                        <label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="location_service"
                                                                                                id="location_service-0"
                                                                                                value="1" {{ @$data['configs']['location_service'] === '1' ? 'checked' :'' }}>
                                                                                            <span> {{ _trans('settings.Enable') }}</span></label><label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="location_service"
                                                                                                id="location_service-1"
                                                                                                value="0" {{ @$data['configs']['location_service'] === '0' ? 'checked' :'' }}>
                                                                                            <span> {{ _trans('settings.Disable') }}</span></label>
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
                                                                                               autocomplete="off"
                                                                                        >
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
                                                                                               autocomplete="off"
                                                                                        >
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
                                                                      {{ _trans('settings.Currency setting') }}
                                                                </legend>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                             {{ _trans('settings.Currency') }}
                                                                        </label>
                                                                        <div class="col-sm-3">
                                                                            <div><select id="select_currency_symbol"
                                                                                         name="currency"
                                                                                         class="custom-select"
                                                                                         style="background-image: url(&quot;https://pipex.gainhq.com/images/chevron-down.svg&quot;);">
                                                                                    @foreach ($data['currencies'] as $key => $currency)
                                                                                        <option
                                                                                            value="{{ $currency->id }}" {{ @$data['configs']['currency'] == $currency->id ? 'selected' :'' }}>
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
                                                                <button class="btn btn-primary mr-2"><span
                                                                        class="w-100">
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
