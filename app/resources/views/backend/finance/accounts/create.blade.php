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
                            @if (hasPermission('account_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('hrm.accounts.index') }}">{{ _trans('common.List') }}</a>
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
                                                <label class="cus-label">{{ _trans('common.Name') }}</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->name : old('name') }}"
                                                    required placeholder="{{ _trans('common.Enter Name') }}">
                                                @if ($errors->has('name'))
                                                    <div class="error">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Balance') }}</label>
                                                <input type="number" name="balance" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->amount : old('balance') }}"
                                                    required placeholder="2000.00">
                                                @if ($errors->has('balance'))
                                                    <div class="error">{{ $errors->first('balance') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('account.Account Name') }}</label>
                                                <input type="text" name="ac_name" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->ac_name : old('ac_name') }}"
                                                    required placeholder="{{ _trans('common.Enter Account Name') }}">
                                                @if ($errors->has('ac_name'))
                                                    <div class="error">{{ $errors->first('ac_name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('account.Account Number') }}</label>
                                                <input type="text" name="ac_number" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->ac_number : old('ac_number') }}"
                                                    required placeholder="{{ _trans('common.Enter Account Number') }}">
                                                @if ($errors->has('ac_number'))
                                                    <div class="error">{{ $errors->first('ac_number') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('account.Code') }}</label>
                                                <input type="text" name="code" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->code : old('code') }}"
                                                    required placeholder="{{ _trans('common.Enter Code') }}">
                                                @if ($errors->has('code'))
                                                    <div class="error">{{ $errors->first('code') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('account.Branch') }}</label>
                                                <input type="text" name="branch" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->branch : old('branch') }}"
                                                    required placeholder="{{ _trans('common.Enter Account Name') }}">
                                                @if ($errors->has('branch'))
                                                    <div class="error">{{ $errors->first('branch') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('account.Status') }}</label>
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
                                    </div>

                                    @if (@$data['url'])
                                        <div class="row  mt-20">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">Save</button>
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
