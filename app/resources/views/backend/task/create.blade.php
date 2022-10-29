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
                            @if (hasPermission('task_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('task.index') }}">{{ _trans('common.List') }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-body">


                                <form action="{{ $data['url'] }}" enctype="multipart/form-data" method="post"
                                    id="attendanceForm">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{ @$request->project_id }}">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('common.Name') }}</label>
                                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                                                @if ($errors->has('name'))
                                                    <div class="error">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('project.Priority') }}</label>
                                                <select name="priority" class="form-control select2" required>
                                                    <option value="32">{{ _trans('project.Low') }}</option>
                                                    <option value="31">{{ _trans('project.Medium') }}</option>
                                                    <option value="30">{{ _trans('project.High') }}</option>
                                                    <option value="29" selected>{{ _trans('project.Urgent') }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('priority'))
                                                    <div class="error">{{ $errors->first('priority') }}</div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('project.Progress') }}
                                                    <small id="progress_percentage"> 0% </small> </label>
                                                <input type="range" name="progress" class="form-control" min="0"
                                                    max="100" value="0" oninput="progressValue(this.value)"
                                                    onchange="progressValue(this.value)">
                                                @if ($errors->has('progress'))
                                                    <div class="error">{{ $errors->first('progress') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Status') }}</label>
                                                <select name="status" class="form-control select2" required>
                                                    <option value="24">{{ _trans('project.Not Started') }}</option>
                                                    <option value="26" selected>{{ _trans('project.In Progress') }}
                                                    </option>
                                                    <option value="25">{{ _trans('project.On Hold') }}</option>
                                                    <option value="28">{{ _trans('project.Cancelled') }}</option>
                                                    <option value="27">{{ _trans('project.Completed') }}</option>
                                                </select>
                                                @if ($errors->has('month'))
                                                    <div class="error">{{ $errors->first('month') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                      

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Start Date') }}</label>
                                                <input type="date" name="start_date" class="form-control"
                                                    value="{{ date('Y-m-d') }}" required>
                                                @if ($errors->has('start_date'))
                                                    <div class="error">{{ $errors->first('start_date') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('project.End Date') }}</label>
                                                <input type="date" name="end_date" class="form-control"
                                                    value="{{ date('Y-m-d') }}" required>
                                                @if ($errors->has('end_date'))
                                                    <div class="error">{{ $errors->first('end_date') }}</div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('project.Assignees') }}</label>
                                                <input hidden value="{{ _trans('project.Select Members') }}" id="select_members">
                                                <select name="user_ids[]" class="form-control" id="members" required multiple>
                                                </select>
                                                @if ($errors->has('estimated_hour'))
                                                    <div class="error">{{ $errors->first('estimated_hour') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                       

                                       




                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Description') }}</label>
                                                <textarea type="text" name="content" class="form-control content" required>{{ old('content') }}</textarea>
                                                @if ($errors->has('content'))
                                                    <div class="error">{{ $errors->first('content') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="checkboxSuccess3"></label>
                                                <div class="form-group clearfix">
                                                    <div class="icheck-primary d-inline">
                                                        <input name="notify_all_users" value="1" class="checkbox" type="checkbox" id="checkboxSuccess3">
                                                        <label for="checkboxSuccess3">
                                                            {{ _trans('project.Allow notifications for members') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('priority'))
                                                    <div class="error">{{ $errors->first('priority') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="email_notification"></label>
                                                <div class="form-group clearfix">
                                                    <div class="icheck-primary d-inline">
                                                        <input name="notify_all_users_email" value="1"  type="checkbox" id="email_notification">
                                                        <label for="email_notification">
                                                            {{ _trans('project.Allow email notifications for members') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('priority'))
                                                    <div class="error">{{ $errors->first('priority') }}</div>
                                                @endif
                                            </div>
                                        </div> --}}

                                    </div>

                                    @if (@$data['url'])
                                        <div class="row  mt-20">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">{{ _trans('common.Save')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
@section('script')
    <script src="{{ asset('public/backend/js/pages/__project.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ asset('public/backend/js/image_preview.js') }}"></script>
    <script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/ckeditor/config.js') }}"></script>
    <script src="{{ asset('public/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('public/ckeditor/build-config.js') }}"></script>
    <script src="{{ asset('public/backend/js/global_ckeditor.js') }}"></script>
@endsection
