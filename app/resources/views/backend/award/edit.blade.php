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
                            @if (hasPermission('award_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('award.index') }}">{{ _trans('common.List') }}</a>
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
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('project.Employee') }}</label>
                                                <input hidden value="{{ _trans('project.Select Employee') }}"
                                                    id="select_members">
                                                <select name="user_id" class="form-control" id="members" required>
                                                    @if (@$data['edit'])
                                                        <option value="{{ @$data['edit']->user->id }}" selected>
                                                            {{ @$data['edit']->user->name }}</option>
                                                    @endif
                                                </select>
                                                @if ($errors->has('user_id'))
                                                    <div class="error">{{ $errors->first('user_id') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Type') }}</label>
                                                <input hidden value="{{ _trans('award.Select Type') }}"
                                                    id="select_award_type">
                                                <select name="award_type" class="form-control select2" id="award_type"
                                                    required>
                                                    @foreach ($data['award_types'] as $award_type)
                                                        <option value="{{ @$award_type->id }}"
                                                            {{ @$data['edit']->award_type_id == $award_type->id ? ' selected' : '' }}>
                                                            {{ @$award_type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('award_type'))
                                                    <div class="error">{{ $errors->first('award_type') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('award.Gift') }}</label>
                                                <input type="text" name="gift" class="form-control" required
                                                    value="{{ @$data['edit'] ? @$data['edit']->gift : old('gift') }}">
                                                @if ($errors->has('gift'))
                                                    <div class="error">{{ $errors->first('gift') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Date') }}</label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ @$data['edit'] ? @$data['edit']->date : date('Y-m-d') }}"
                                                    required>
                                                @if ($errors->has('date'))
                                                    <div class="error">{{ $errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Status') }}</label>
                                                <select name="status" class="form-control select2" required>
                                                    <option value="1"
                                                        {{ @$data['edit'] ? ($data['edit']->status_id == 1 ? 'Selected' : '') : '' }}>
                                                        {{ _trans('payroll.Active') }}</option>
                                                    <option value="4"
                                                        {{ @$data['edit'] ? ($data['edit']->status_id == 4 ? 'Selected' : '') : '' }}>
                                                        {{ _trans('payroll.Inactive') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div class="error">{{ $errors->first('status') }}</div>
                                                @endif
                                            </div>
                                        </div>





                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Amount') }}</label>
                                                <input type="number" name="amount" class="form-control" id="amount"
                                                    value="{{ @$data['edit'] ? $data['edit']->amount : old('amount') }}" required>
                                                @if ($errors->has('amount'))
                                                    <div class="error">{{ $errors->first('amount') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ _trans('common.Attachment') }}
                                                    <a 
                                                    data-toggle="tooltip"
                                                    title="<img width='100' src='{{ uploaded_asset($data['edit']->attachment) }}' />">
                                                        <i class="fas fa-link ml-1"></i>
                                                    </a>
                                                </label>
                                                <input type="file" name="attachment" class="form-control" id="attachment"
                                                    value="{{ old('attachment') }}">
                                                @if ($errors->has('status'))
                                                    <div class="error">{{ $errors->first('status') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Award Information') }}</label>
                                                <input type="text" name="award_info" class="form-control" id="award_info"
                                                    value="{{ @$data['edit'] ? $data['edit']->gift_info : old('award_info') }}" required>
                                                @if ($errors->has('award_info'))
                                                    <div class="error">{{ $errors->first('award_info') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        @include('backend.performance.goal.goal_select')

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Description') }}</label>
                                                <textarea type="text" name="content" class="form-control content" required>{!! @$data['edit']->description !!}</textarea>
                                                @if ($errors->has('content'))
                                                    <div class="error">{{ $errors->first('content') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if (@$data['url'])
                                        <div class="row  mt-20">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">{{ _trans('common.Save') }}</button>
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
    <script src="{{ asset('public/backend/js/pages/__award.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ asset('public/backend/js/image_preview.js') }}"></script>
    <script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/ckeditor/config.js') }}"></script>
    <script src="{{ asset('public/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('public/ckeditor/build-config.js') }}"></script>
    <script src="{{ asset('public/backend/js/global_ckeditor.js') }}"></script>
@endsection
