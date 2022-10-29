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
                    <div class="col-sm-12">
                        <a href="{{ route('roles.index') }}"
                           class="btn btn-primary float-right"> <i
                                    class="fa fa-arrow-left"></i> {{ _trans('common.Back') }}</a>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="" class="form-validate" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="card">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label class="form-label cus-label" for="fv-full-name">Name: </label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="fv-full-name" name="name"
                                                   required placeholder="{{ _trans('common.Name') }}">
                                        </div>
                                        @if($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="fv-email">{{__('slug')}}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="fv-email" name="slug"
                                                >
                                        </div>
                                        @if($errors->has('slug'))
                                            <p class="text-danger">{{ $errors->first('slug') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="fv-email">{{__('Status')}}</label>
                                        <div class="form-control-wrap">
                                            <select name="status_id" id="status_id" class="form-control" required>
                                                <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                                {{-- <option value="1" {{ $data['role']->status_id == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="2" {{ $data['role']->status_id == 2 ? 'selected' : '' }}>{{ __('In-active') }}</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-inner">
                                    <table class="table table-striped role-create-table role-permission ">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('Module')}}/{{__('Sub-module')}}</th>
                                            <th scope="col">{{__('Permissions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['permissions'] as $permission)
                                            <tr>
                                                <td><span class="text-capitalize">{{__($permission->attribute)}}</span>
                                                </td>

                                                <td>
                                                    @foreach($permission->keywords as $key=>$keyword)
                                                        <div class="custom-control custom-checkbox">
                                                            @if($keyword != "")
                                                                <input type="checkbox"
                                                                       class="custom-control-input read common-key"
                                                                       name="permissions[]" value="{{$keyword}}"
                                                                       id="{{$keyword}}" {{ in_array($keyword, $data['role']->permissions)? 'checked':''}}>
                                                                <label class="custom-control-label"
                                                                       for="{{$keyword}}">{{__($key)}}</label>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-12 text-right mt-4 mr-5">
                                            <div class="form-group">
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary submit-margin-right">{{{__('submit')}}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script src="{{ asset('public/backend/js/_roles.js') }}"></script>
@endsection

