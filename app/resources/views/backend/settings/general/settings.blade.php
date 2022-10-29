@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper">
        @php
            $general_setting = request()->has('general_setting');
            $email_setup = request()->has('email_setup');
            $storage_setup = request()->has('storage_setup');
            $db_backup = request()->has('db_backup');

            $default_tab='';
            if (!$general_setting && !$email_setup && !$storage_setup && !$db_backup) {
                $default_tab='active';
            }else{
                $default_tab='';
            }
        @endphp
            <!-- Main content -->
        <div class="container-fluid  border-radius-5 p-imp-30">
            <div class="main-panel">
                <div class="">
                    <div class="vertical-tab">
                        <div class="row no-gutters">
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
                                                data-toggle="tab" href="#General"
                                                class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3 {{ $general_setting ? 'active':'' }} {{  $default_tab }}"><span>{{ _trans('settings.General') }}</span>
                                                <span class="active-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                               width="24" height="24"
                                                                               viewBox="0 0 24 24" fill="none"
                                                                               stroke="currentColor" stroke-width="2"
                                                                               stroke-linecap="round"
                                                                               stroke-linejoin="round"
                                                                               class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span></a>
                                            <a data-toggle="tab" href="#Email"
                                               class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3 {{ $email_setup ? 'active':'' }}"><span>{{ _trans('settings.Email setup') }}</span>
                                                <span class="active-icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span>
                                            </a>
                                            <a data-toggle="tab" href="#storage"
                                               class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3 {{ $storage_setup ? 'active':'' }}"><span>{{ _trans('settings.Storage Setup') }}</span>
                                                <span class="active-icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span>
                                            </a>
                                            <a data-toggle="tab" href="#db-backup"
                                               class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3 {{ $db_backup ? 'active':'' }}"><span>{{ _trans('settings.Database Backup') }}</span>
                                                <span class="active-icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span>
                                            </a>
                                            <a data-toggle="tab" href="#about_system"
                                               class="text-capitalize tab-item-link d-flex justify-content-between my-2 my-sm-3"><span>{{ _trans('settings.About System') }}</span>
                                                <span class="active-icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-chevron-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 pl-md-3 pt-md-0 pt-sm-4 pt-4">
                                <div class="card card-with-shadow border-0">
                                    <div class="tab-content px-primary">
                                        <div id="General"
                                             class="tab-pane {{ $general_setting ? 'active':'' }}  {{  $default_tab }}">
                                            <div class="d-flex justify-content-between">
                                                <h5
                                                    class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                                    General</h5>
                                                <div class="d-flex align-items-center mb-0">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="content py-primary">
                                                <div props="[object Object]" id="General-0">
                                                    <form action="{{ route('manage.settings.update') }}" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <fieldset class="form-group mb-5">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                            {{ _trans('common.Name') }}</label>
                                                                        <div class="col-sm-9">
                                                                            <div><input type="text"
                                                                                        name="company_name"
                                                                                        id="company_name"
                                                                                        required="required"
                                                                                        placeholder="{{ _trans('settings.Type your company name') }}"
                                                                                        autocomplete="off"
                                                                                        class="form-control"
                                                                                        value="{{ config('settings.app')['company_name'] }}"
                                                                                >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label h-fit-content">
                                                                            {{ _trans('settings.Company logo backend (white)') }}<br> <small
                                                                                class="text-muted font-italic">{{ _trans('settings.(Recommended
                                                                                size: 210 x 50 px)') }}</small></label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div
                                                                                    class="custom-image-upload-wrapper">
                                                                                    <div class="image-area d-flex">

                                                                                        @if(env('FILESYSTEM_DRIVER') == 'server')
                                                                                            <img
                                                                                                src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo_backend']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @elseif(env('FILESYSTEM_DRIVER') == 'local')
                                                                                            <img
                                                                                                src="{{ Storage::url(config('settings.app')['company_logo_backend']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @else
                                                                                            <img
                                                                                                src="{{ Storage::url(config('settings.app')['company_logo_backend']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="input-area"><label
                                                                                            id="upload-label"
                                                                                            for="appSettings_company_logo">
                                                                                            {{ _trans('settings.Change logo') }}
                                                                                        </label> <input
                                                                                            id="appSettings_company_logo"
                                                                                            type="file"
                                                                                            name="company_logo_backend"
                                                                                            class="form-control d-none">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!---->
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label h-fit-content">
                                                                            {{ _trans('settings.Company logo frontend (black)') }} <br> <small
                                                                                class="text-muted font-italic">{{ _trans('settings.(Recommended
                                                                                size: 210 x 50 px)') }}</small></label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div
                                                                                    class="custom-image-upload-wrapper">
                                                                                    <div class="image-area d-flex">

                                                                                        @if(env('FILESYSTEM_DRIVER') == 'server')
                                                                                            <img
                                                                                                src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo_frontend']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh_b"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @elseif(env('FILESYSTEM_DRIVER') == 'local')
                                                                                            <img
                                                                                                src="{{ Storage::url(config('settings.app')['company_logo_frontend']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh_b"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @else
                                                                                            <img
                                                                                                src="{{ Storage::url(config('settings.app')['company_logo_frontend']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh_b"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="input-area"><label
                                                                                            id="upload-label"
                                                                                            for="appSettings_company_logo_black">
                                                                                            {{ _trans('settings.Change logo') }}
                                                                                        </label> <input
                                                                                            id="appSettings_company_logo_black"
                                                                                            type="file"
                                                                                            name="company_logo_frontend"
                                                                                            class="form-control d-none">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!---->
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label h-fit-content">
                                                                            {{ _trans('settings.Company icon') }}<br> <small
                                                                                class="text-muted font-italic">{{ _trans('settings.(Recommended
                                                                                size: 50 x 50 px)') }} </small></label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div
                                                                                    class="custom-image-upload-wrapper">
                                                                                    <div class="image-area d-flex">

                                                                                        @if(env('FILESYSTEM_DRIVER') == 'server')
                                                                                            <img
                                                                                                src="{{ Storage::disk('s3')->url(config('settings.app')['company_icon']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh1"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @elseif(env('FILESYSTEM_DRIVER') == 'local')
                                                                                            <img
                                                                                                src="{{ Storage::url(config('settings.app')['company_icon']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh1"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @else
                                                                                            <img
                                                                                                src="{{ Storage::url(config('settings.app')['company_icon']) }}"
                                                                                                height="30"
                                                                                                style="display:inline-block;"
                                                                                                id="bruh1"
                                                                                                class="img-fluid mx-auto my-auto">
                                                                                        @endif

                                                                                    </div>
                                                                                    <div class="input-area"><label
                                                                                            id="upload-label"
                                                                                            for="appSettings_company_icon">
                                                                                            {{ _trans('settings.Change icon') }}
                                                                                        </label> <input
                                                                                            id="appSettings_company_icon"
                                                                                            type="file"
                                                                                            name="company_icon"
                                                                                            class="form-control d-none">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row"><label
                                                                            class="col-sm-3 col-form-label">
                                                                            {{ _trans('settings.Android url') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <input type="url" class="form-control"
                                                                                       name="android_url"
                                                                                       value="{{ config('settings.app')['android_url'] }}"
                                                                                       placeholder="Android url">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">
                                                                            {{ _trans('settings.Ios url') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <input type="url" class="form-control"
                                                                                       name="ios_url"
                                                                                       value="{{ config('settings.app')['ios_url'] }}"
                                                                                       placeholder="{{ _trans('settings.Ios url') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">
                                                                            {{ _trans('settings.Site maintenance') }}
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                            <div>
                                                                                <div class="radio-button-group">
                                                                                    <div data-toggle="buttons"
                                                                                         class="btn-group btn-group-toggle">
                                                                                        <label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="site_under_maintenance"
                                                                                                id="site_under_maintenance-0"
                                                                                                value="1" {{ config('settings.app')['site_under_maintenance'] === '1' ? 'checked' :'' }}>
                                                                                            <span> {{ _trans('settings.Enable') }} </span></label><label
                                                                                            class="btn border"><input
                                                                                                type="radio"
                                                                                                name="site_under_maintenance"
                                                                                                id="site_under_maintenance-1"
                                                                                                value="0" {{ config('settings.app')['site_under_maintenance'] === '0' ? 'checked' :'' }}>
                                                                                            <span>{{ _trans('settings.Disable') }}</span></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                @if(hasPermission('general_settings_update'))
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

                                        <div id="Email" class="tab-pane fade {{ $email_setup ? 'active':'' }}">
                                            <div class="d-flex justify-content-between">
                                                <h5
                                                    class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                                     {{ _trans('settings.Email setup [SMTP]') }}</h5>
                                                <div class="d-flex align-items-center mb-0">
                                                    <!---->
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="content py-primary">
                                                <form action="{{ route('manage.settings.update.email') }}" method="post"
                                                      class="mb-0">
                                                    @csrf
                                                    <div class="form-group row align-items-center d-none"><label
                                                            for="emailSettingsProvider"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                             {{ _trans('settings.Supported mail services') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><select name="MAIL_MAILER" id="emailSettingsProvider"
                                                                         class="custom-select"
                                                                         style="background-image: url(&quot;https://pipex.gainhq.com/images/chevron-down.svg&quot;);">

                                                                    <option value="smtp" selected>
                                                                        {{ _trans('settings.SMTP') }}
                                                                    </option>
                                                                </select>
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                             {{ _trans('settings.MAIL HOST') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_HOST"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL HOST') }}"
                                                                        autocomplete="off" value="{{ env('MAIL_HOST')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.MAIL PORT') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_PORT"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL PORT') }}" autocomplete="off"
                                                                        value="{{ env('MAIL_PORT')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.MAIL USERNAME') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_USERNAME"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL USERNAME') }}" autocomplete="off"
                                                                        value="{{ env('MAIL_USERNAME')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.MAIL FROM ADDRESS') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_FROM_ADDRESS"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL FROM ADDRESS') }}"
                                                                        autocomplete="off"
                                                                        value="{{ env('MAIL_FROM_ADDRESS')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.MAIL PASSWORD') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_PASSWORD"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL PASSWORD') }}" autocomplete="off"
                                                                        value="{{ env('MAIL_PASSWORD')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.MAIL ENCRYPTION') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_ENCRYPTION"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL ENCRYPTION') }}" autocomplete="off"
                                                                        value="{{ env('MAIL_ENCRYPTION')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsFromName"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.MAIL FROM NAME') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div><input type="text" name="MAIL_FROM_NAME"
                                                                        id="emailSettingsFromName" required="required"
                                                                        placeholder="{{ _trans('settings.MAIL FROM NAME') }}" autocomplete="off"
                                                                        value="{{ env('MAIL_FROM_NAME')}}"
                                                                        class="form-control ">
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <div class="mt-5">
                                                        <button class="btn btn-primary mr-2">
                                                            {{ _trans('common.Save') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div id="storage" class="tab-pane fade {{ $storage_setup ? 'active':'' }}">
                                            <div class="d-flex justify-content-between">
                                                <h5
                                                    class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                                    {{ _trans('settings.Storage setup') }}</h5>
                                                <div class="d-flex align-items-center mb-0">
                                                    <!---->
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="content py-primary">
                                                <form action="{{ route('manage.settings.update.storage') }}"
                                                      method="post" class="mb-0">
                                                    @csrf
                                                    <div class="form-group row align-items-center"><label
                                                            for="emailSettingsProvider"
                                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                                            {{ _trans('settings.Default storage') }}
                                                        </label>
                                                        <div class="col-lg-8 col-xl-8">
                                                            <div class="form-group">
                                                                <select name="FILESYSTEM_DRIVER" id="select_storage"
                                                                        class="form-control" required>
                                                                    <option value="local">Local</option>
                                                                    <option value="s3">S3</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="s3_section d-none">
                                                        <div class="form-group row align-items-center"><label
                                                                for="emailSettingsFromName"
                                                                class="col-lg-3 col-xl-3 mb-lg-0">
                                                                AWS ACCESS KEY ID <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-8 col-xl-8">
                                                                <div><input type="text" name="AWS_ACCESS_KEY_ID"
                                                                            id="emailSettingsFromName"
                                                                            required="required"
                                                                            placeholder="AWS ACCESS KEY ID"
                                                                            autocomplete="off"
                                                                            value="{{ env('AWS_ACCESS_KEY_ID') }}"
                                                                            class="form-control ">
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center"><label
                                                                for="emailSettingsFromEmail"
                                                                class="col-lg-3 col-xl-3 mb-lg-0">
                                                                AWS SECRET ACCESS KEY
                                                            </label>
                                                            <div class="col-lg-8 col-xl-8">
                                                                <div><input type="text" name="AWS_SECRET_ACCESS_KEY"
                                                                            value="{{ env('AWS_SECRET_ACCESS_KEY') }}"
                                                                            required="required"
                                                                            placeholder="AWS SECRET ACCESS KEY"
                                                                            autocomplete="off" class="form-control ">
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center"><label
                                                                for="emailSettingsFromEmail"
                                                                class="col-lg-3 col-xl-3 mb-lg-0">
                                                                AWS DEFAULT REGION
                                                            </label>
                                                            <div class="col-lg-8 col-xl-8">
                                                                <div><input type="text" name="AWS_DEFAULT_REGION"
                                                                            value="{{ env('AWS_DEFAULT_REGION') }}"
                                                                            required="required"
                                                                            placeholder="AWS DEFAULT REGION"
                                                                            autocomplete="off" class="form-control ">
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center"><label
                                                                for="emailSettingsFromEmail"
                                                                class="col-lg-3 col-xl-3 mb-lg-0">
                                                                AWS BUCKET
                                                            </label>
                                                            <div class="col-lg-8 col-xl-8">
                                                                <div><input type="text" name="AWS_BUCKET"
                                                                            value="{{ env('AWS_BUCKET') }}"
                                                                            required="required"
                                                                            placeholder="AWS BUCKET" autocomplete="off"
                                                                            class="form-control ">
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center"><label
                                                                for="emailSettingsFromEmail"
                                                                class="col-lg-3 col-xl-3 mb-lg-0">
                                                                AWS ENDPOINT
                                                            </label>
                                                            <div class="col-lg-8 col-xl-8">
                                                                <div><input type="text" name="AWS_ENDPOINT"
                                                                            value="{{ env('AWS_ENDPOINT') }}"
                                                                            required="required"
                                                                            placeholder="AWS ENDPOINT"
                                                                            autocomplete="off" class="form-control ">
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <div class="mt-5">
                                                        <button class="btn btn-primary mr-2">
                                                            {{ _trans('common.Save') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div id="db-backup" class="tab-pane fade {{ $db_backup ? 'active':'' }}">
                                            <div class="d-flex justify-content-between">
                                                <h5
                                                    class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">{{ _trans('settings.Database backup') }} </h5>
                                                <div class="d-flex align-items-center mb-0">
                                                    <a href="{{ route('database.export') }}"
                                                       class="btn btn-sm btn-primary">{{ _trans('settings.Backup Database') }}</a>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="content py-primary">
                                                <div class="dataTable-btButtons">
                                                    <table id="table"
                                                           class="table card-table table-vcenter datatable mb-0 w-100">
                                                        <thead>
                                                        <tr>
                                                            <td>{{ _trans('common.File name') }}</td>
                                                            <td>{{ _trans('common.Action') }}</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="__database_tbody">
                                                        @foreach($data['databases'] as $key => $item)
                                                            <tr>
                                                                <td>{{ $item->path }}</td>
                                                                <td>
                                                                    <div class="flex-nowrap">
                                                                        <div class="dropdown position-static">
                                                                            <button
                                                                                class="btn btn-white dropdown-toggle align-text-top action-dot-btn"
                                                                                data-boundary="viewport"
                                                                                data-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                <i class="fas fa-ellipsis-v"
                                                                                   aria-hidden="true"></i>
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right"
                                                                                style="">
                                                                                <a target="_blank"
                                                                                   href="{{ url($item->path) }}"
                                                                                   class="dropdown-item"
                                                                                   onclick="">
                                                                                    {{ _trans('common.Download') }}
                                                                                </a>
                                                                                <a
                                                                                    href="{{ route('database.destroy',$item->id) }}"
                                                                                    class="dropdown-item" onclick="">
                                                                                    {{ _trans('common.Delete') }}
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="about_system" class="tab-pane fade ">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">{{ _trans('settings.About System') }} </h5>

                                            </div>

                                            <hr>
                                            <div class="col-lg-6">
                                                <div class="form-group row align-items-center"><label
                                                        for="emailSettingsFromEmail"
                                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                                        {{ _trans('common.Version') }}
                                                    </label>
                                                    <div class="col-lg-8 col-xl-8">
                                                        <div>
                                                            <span class="text-muted">
                                                                {{ @aboutSystem()['version'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center"><label
                                                        for="emailSettingsFromEmail"
                                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                                        {{ _trans('common.Release Date') }}
                                                    </label>
                                                    <div class="col-lg-8 col-xl-8">
                                                        <div>
                                                            <span class="text-muted">
                                                                {{ showDate(@aboutSystem()['release_date']) }}
                                                            </span>
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
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ url('public/backend/js/image_preview.js') }}"></script>
@endsection
