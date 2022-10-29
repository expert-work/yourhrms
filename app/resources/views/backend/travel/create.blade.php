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
                            @if (hasPermission('travel_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('travel.index') }}">{{ _trans('common.List') }}</a>
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
                                                <input hidden value="{{ _trans('project.Select Employee') }}" id="select_members">
                                                <select name="user_id" class="form-control" id="members" required>
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
                                                <select name="travel_type" class="form-control select2" id="travel_type"
                                                    required>
                                                        @foreach ($data['types'] as $client)
                                                            <option value="{{ @$client->id }}">
                                                                {{ @$client->name }}</option>
                                                        @endforeach
                                                </select>
                                                @if ($errors->has('travel_type'))
                                                    <div class="error">{{ $errors->first('travel_type') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('travel.Motive') }}</label>
                                                <input type="text" name="motive" class="form-control" required
                                                    value="{{ old('motive') }}">
                                                @if ($errors->has('motive'))
                                                    <div class="error">{{ $errors->first('motive') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="cus-label">{{ _trans('travel.Place') }}</label>
                                                <input type="text" name="place" class="form-control" required
                                                    value="{{ old('place') }}">
                                                @if ($errors->has('place'))
                                                    <div class="error">{{ $errors->first('place') }}</div>
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
                                                <label class="cus-label">{{ _trans('common.End Date') }}</label>
                                                <input type="date" name="end_date" class="form-control"
                                                    value="{{ date('Y-m-d', strtotime('+7 day')) }}" required>
                                                @if ($errors->has('end_date'))
                                                    <div class="error">{{ $errors->first('end_date') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                                                       


                                       


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('travel.Expected Amount') }}</label>
                                                <input type="number" name="expect_amount" class="form-control" id="amount"
                                                    value="{{ old('expect_amount') }}" required>
                                                @if ($errors->has('expect_amount'))
                                                    <div class="error">{{ $errors->first('expect_amount') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('travel.Actual Amount') }}</label>
                                                <input type="number" name="actual_amount" class="form-control" id="amount"
                                                    value="{{ old('actual_amount') }}" required>
                                                @if ($errors->has('actual_amount'))
                                                    <div class="error">{{ $errors->first('actual_amount') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('travel.Mode') }}</label>
                                                <select name="mode" class="form-control select2" required>
                                                    <option value="bus" >{{ _trans('travel.Bus') }}</option>
                                                    <option value="train" >{{ _trans('travel.Train') }}</option>
                                                    <option value="plane" >{{ _trans('travel.Plane') }}</option>
                                                </select>
                                                @if ($errors->has('mode'))
                                                    <div class="error">{{ $errors->first('mode') }}</div>
                                                @endif
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ _trans('common.Attachment') }}</label>
                                                <input type="file" name="attachment" class="form-control" id="attachment"
                                                    value="{{ old('attachment') }}" >
                                                @if ($errors->has('status'))
                                                    <div class="error">{{ $errors->first('status') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                         

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Description') }}</label>
                                                <textarea type="text" name="content" class="form-control content" >{{ old('content') }}</textarea>
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
