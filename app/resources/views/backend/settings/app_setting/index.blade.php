@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('style')
    <style>
        .icon-upload{
            display: flex;
            justify-content: center;
        }

        .icon-upload .sizing{
            position: relative;
            width: 80px;
            height: 80px;
        }

        .icon-upload .sizing img {
            border: 3px solid #adb5bd;
            border-radius: 10px;
            margin: 0 auto;
            padding: 1px;
            width: 80px !important;
            height: 80px !important;
        }

        .icon-upload .sizing label{
            position: absolute;
            top: 50px;
            right: 1px;
        }

        .download-icon {
            border-radius: 7px;
            width: 28px;
            height: 28px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #7f58fea3;
        }

        .download-icon i {
            color: #fff;

        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper cus-content-wrapper">
        <!-- Main content -->
        <div class="container-fluid border-radius-5 p-imp-30">
            <div class="row mt-4">
                <div class="offset-md-2 col-md-8 pr-md-2">
                    <div class="card card-with-shadow border-0">
                        <div class="px-primary py-primary">
                            <h4>App Screen Setup</h4>
                            <hr>
                            <div id="General-0">
                                <fieldset class="form-group mb-5">
                                    {{-- <div class="row">
                                        <div class="col-md-12">
                                            @foreach ($data['settings'] as $key => $setting)
                                                <form action="{{ route('appSettingsIcon') }}" method="POST" enctype="multipart/form-data" id="icon-settings{{$setting->id}}">
                                                    <div class="row @if ($loop->odd) btn_odd_row @else btn_even_row @endif d-flex justify-content-center p-2">
                                                            @csrf
                                                            <input name="id" type="hidden"
                                                            value="{{ $setting->id }}">
                                                            <div class="col-md-3 text-center position-relative">
                                                                <img class="app-icon-img img-fluid img-circle "
                                                                src="{{ Storage::url($setting->icon) }}">
                                                                <!-- <x-image-upload :preview="'true'" :fileType="'image'" :name="'icon'" :label="''"/> -->
                                                                <label for="icon"
                                                                    class="download-icon position-absolute">
                                                                    <i class="fa fa-upload" aria-hidden="true">{{ $setting->id }}</i>
                                                                </label>
                                                                <input type="file" accept=".png, .jpg, .jpeg, .svg, .gif"
                                                                id='icon' name="icon" hidden="true" onchange="document.getElementById('icon-settings{{$setting->id}}').submit()" />
                                                            </div>
                                                    </form>
                                                        <div class="col-md-6 text-center align-self-center">
                                                            <form action="{{ route('appSettingsTitle') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input name="id" type="hidden" value="{{ $setting->id }}">
                                                                <input name="title" type="text" class="form-control"
                                                                    value="{{ $setting->name }}">
                                                            </form>
                                                        </div>
                                                    <div class="col-md-3 align-self-center">
                                                        <div class="text-center">
                                                            <label class="switch">
                                                                <input type="checkbox" class="setup_switch"
                                                                    data-name="{{ $setting->name }}"
                                                                    data-id="{{ $setting->id }}" name="{{ $setting->name }}"
                                                                    {{ $setting->status_id == 1 ? 'checked' : '' }}
                                                                    value=" {{ $setting->status_id == 1 ? 1 : '' }}">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div> --}}

                                    
                                    <table class="table table-striped table-hover table-responsive-sm text-center">
                                        @foreach ($data['settings'] as $setting)
                                            <tr>
                                                <td>
                                                    <form action="{{ route('appSettingsIcon') }}" method="POST" enctype="multipart/form-data" id="icon-settings{{$setting->id}}">
                                                        @csrf
                                                        <div class="icon-upload">
                                                            <div class="sizing">
                                                                {{-- <img class="p-2" src="{{ Storage::url($setting->icon) }}"> --}}
                                                                <img class="p-2" src="{{ my_asset($setting->icon) }}">
                                                                <label for="icon{{ $setting->id }}" class="download-icon">
                                                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                                                </label>
                                                                <input type="hidden" name="id" value="{{ $setting->id }}" />
                                                                <input type="file" accept=".png, .jpg, .jpeg" id='icon{{ $setting->id }}' name="icon" hidden="true" onchange="submit()"/>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('appSettingsTitle') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                        <input name="id" type="hidden" value="{{ $setting->id }}">
                                                        <input name="title" type="text" class="form-control" value="{{ $setting->name }}">
                                                    </form>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="setup_switch"
                                                            data-name="{{ $setting->name }}"
                                                            data-id="{{ $setting->id }}" name="{{ $setting->name }}"
                                                            {{ $setting->status_id == 1 ? 'checked' : '' }}
                                                            value=" {{ $setting->status_id == 1 ? 1 : '' }}">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>


                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="appScreenSetupUpdate" value="{{ route('appScreenSetupUpdate') }}">
    <input type="hidden" id="token" value="{{ csrf_token() }}">
@endsection
