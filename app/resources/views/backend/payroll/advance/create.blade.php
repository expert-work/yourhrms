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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ _translate('Dashboard')
                                }}</a></li>
                        @if (hasPermission('advance_salaries_list'))
                        <li class="breadcrumb-item"><a href="{{ route('hrm.payroll_advance_salary.index') }}">{{
                                _trans('common.List') }}</a>
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
                                            <label for="" class="cus-label">{{ _trans('common.Employee') }}</label>
                                            @if (auth()->user()->role->slug == 'staff')
                                            <input type="hidden" name="user_id" class="form-control"
                                                value="{{ auth()->id() }}">
                                            <input type="text" name="r" class="form-control"
                                                value="{{ auth()->user()->name }}" readonly>
                                            @else
                                            <select name="user_id" class="form-control" id="user_id">
                                                <option selected value="{{ @$data['advance']->user_id }}">
                                                    {{ @$data['advance']->employee->name }}</option>
                                            </select>
                                            @endif
                                            @if ($errors->has('user_id'))
                                            <div class="error">{{ $errors->first('user_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Month') }}</label>
                                            <input type="date" name="month" class="form-control"
                                                value="{{ @$data['advance'] ? $data['advance']->date : date('Y-m-d') }}"
                                                required>
                                            @if ($errors->has('month'))
                                            <div class="error">{{ $errors->first('month') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Advance Type') }}</label>
                                            <select name="advance_type" class="form-control select2">
                                                @foreach ($data['advance_types'] as $item)
                                                <option {{ @$data['advance'] ? (@$data['advance']->advance_type_id ==
                                                    $item->id ? 'selected' : '') : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                            @if ($errors->has('advance_type'))
                                            <div class="error">{{ $errors->first('advance_type') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Amount') }}</label>
                                            <input type="number" name="amount" class="form-control"
                                                value="{{ @$data['advance'] ? $data['advance']->request_amount : old('amount') }}"
                                                required placeholder="2000.00">
                                            @if ($errors->has('amount'))
                                            <div class="error">{{ $errors->first('amount') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Recovery Mode') }}</label>
                                            <select name="recovery_mode" class="form-control select2" required>
                                                <option {{ @$data['advance'] ? (@$data['advance']->recovery_mode == 1 ?
                                                    'selected' : '') : '' }}
                                                    value="1">{{ _trans('payroll.Installment') }}</option>
                                                <option {{ @$data['advance'] ? (@$data['advance']->recovery_mode == 2 ?
                                                    'selected' : '') : '' }}
                                                    value="2">{{ _trans('payroll.One Time') }}</option>
                                            </select>
                                            @if ($errors->has('recovery_mode'))
                                            <div class="error">{{ $errors->first('datrecovery_modee') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Recovery Cycle') }}</label>
                                            <select name="recovery_cycle" class="form-control select2" required>
                                                <option selected value="1">{{ _trans('payroll.Monthly') }}
                                                </option>
                                            </select>
                                            @if ($errors->has('recovery_cycle'))
                                            <div class="error">{{ $errors->first('recovery_cycle') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Installment') }}</label>
                                            <input type="number" name="installment_amount" class="form-control"
                                                value="{{ (@$data['advance'] ? $data['advance']->installment_amount : old('installment_amount')) ? old('installment_amount') : '0' }}"
                                                required placeholder="500.00">
                                            @if ($errors->has('installment_amount'))
                                            <div class="error">{{ $errors->first('installment_amount') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Recover From') }}</label>
                                            <input type="date" name="recover_from" class="form-control"
                                                value="{{ @$data['advance'] ? $data['advance']->recover_from : date('Y-m-d') }}"
                                                required>
                                            @if ($errors->has('recover_from'))
                                            <div class="error">{{ $errors->first('recover_from') }}</div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="cus-label">{{ _trans('common.Reason') }}</label>
                                            <textarea type="text" name="reason" class="form-control"
                                                placeholder="{{ _trans('common.Reason') }}"
                                                required>{{ @$data['advance'] ? $data['advance']->remarks : old('installment_amount') }}</textarea>
                                            @if ($errors->has('reason'))
                                            <div class="error">{{ $errors->first('reason') }}</div>
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