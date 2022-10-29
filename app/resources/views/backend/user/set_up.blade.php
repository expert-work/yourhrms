@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="main-panel">
                    <div class="vertical-tab">
                        <div class="row no-gutters">
                            <div class="col-12 pl-md-3 pt-md-0 pt-sm-4 pt-4">

                                @if (url()->current() === route('hrm.payroll_setup.user_setup', [$data['id'], 'contract']))
                                    <div class="d-flex justify-content-between pb-3">
                                        <h5 class="d-flex align-items-center text-capitalize mb-0 title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-lock icon-svg-primary wid-20">
                                                <rect x="3" y="11" width="18" height="11"
                                                    rx="2" ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                            <span class="pl-2">{{ _trans('Set Contract') }} </span>
                                        </h5>
                                        <a href="{{ route('hrm.payroll_setup.user_setup', [$data['id'], 'commissions']) }}"
                                            class="btn btn-info ">{{ _trans('common.Set Commissions') }}</a>
                                    </div>
                                    <div class="card  border-0">
                                        <div class="tab-content px-primary">
                                            <div id="Contract" class="tab-pane active">
                                                <div class="content mb-3">
                                                    <form
                                                        action="{{ route('hrm.payroll_setup.user_setup_update', [$data['id'], $data['slug']]) }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="text" hidden name="user_id"
                                                            value="{{ $data['id'] }}">
                                                        <div class="card-body" data-select2-id="698">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label> {{ _trans('common.Contract Date') }}
                                                                            <span class="text-danger">*</span></label>
                                                                        <div class="input-group">
                                                                            <input type="date" class="form-control date"
                                                                                name="contract_start_date"
                                                                                placeholder="Contract Date"
                                                                                value="{{ @$data['show']->original['data']['contract_start_date'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label> {{ _trans('common.Contract End') }}
                                                                            <span class="text-danger">*</span></label>
                                                                        <div class="input-group">
                                                                            <input type="date" class="form-control date"
                                                                                name="contract_end_date"
                                                                                placeholder="Contract Date"
                                                                                value="{{ @$data['show']->original['data']['contract_end_date'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" data-select2-id="697">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            {{ _trans('common.Basic Salary') }} <span
                                                                                class="text-danger">*</span></label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control"
                                                                                name="basic_salary"
                                                                                value="{{ @$data['show']->original['data']['basic_salary'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6" data-select2-id="696">
                                                                    <div class="form-group" data-select2-id="695">
                                                                        <label for="payslip_type">
                                                                            Payslip Type <i
                                                                                class="text-danger">*</i></label>
                                                                        <select name="payslip_type" id="payslip_type"
                                                                            class="form-control select2">
                                                                            <option value="1" selected="selected">
                                                                                Per Month
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label> {{ _trans('common.Late Check In') }}
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="number" class="form-control"
                                                                            name="late_check_in"
                                                                            value="{{ @$data['show']->original['data']['late_check_in'] }}">
                                                                        <small class="form-text text-muted">
                                                                            {{ _trans('message.Total late check in count.') }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="early_check_out">
                                                                            {{ _trans('common.Early Check out') }} <i
                                                                                class="text-danger">*</i></label>
                                                                        <input type="number" class="form-control"
                                                                            name="early_check_out"
                                                                            value="{{ @$data['show']->original['data']['early_check_out'] }}">
                                                                        <small class="form-text text-muted">
                                                                            {{ _trans('message.Total early check out count.') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label> {{ _trans('common.Extra Leave') }} <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="number" class="form-control"
                                                                            name="extra_leave"
                                                                            value="{{ @$data['show']->original['data']['extra_leave'] }}">
                                                                        <small class="form-text text-muted">
                                                                            {{ _trans('message.Total extra leave in count.') }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="monthly_leave">
                                                                            {{ _trans('common.Monthly Leave') }} <i
                                                                                class="text-danger">*</i></label>
                                                                        <input type="number" class="form-control"
                                                                            name="monthly_leave"
                                                                            value="{{ @$data['show']->original['data']['monthly_leave'] }}">
                                                                        <small class="form-text text-muted">
                                                                            {{ _trans('message.Total monthly leave count.') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="submit"
                                                                    class="btn btn-primary float-right">
                                                                    {{ _trans('common.Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (url()->current() === route('hrm.payroll_setup.user_setup', [$data['id'], 'commissions']))
                                    <div class="d-flex justify-content-between pb-3">
                                        <h5 class="d-flex align-items-center text-capitalize mb-0 title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-lock icon-svg-primary wid-20">
                                                <rect x="3" y="11" width="18" height="11"
                                                    rx="2" ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                            <span class="pl-2">{{ _trans('Set Commission') }} </span>
                                        </h5>
                                        <a href="{{ route('hrm.payroll_setup.user_setup', [$data['id'], 'contract']) }}"
                                            class="btn btn-info ">{{ _trans('common.Set Contract') }}</a>
                                    </div>
                                    <div class="d-flex justify-content-between pb-3">
                                        <h5 class="d-flex align-items-center text-capitalize mb-0 title">
                                            <span class="pl-2">{{ _trans('Addition') }} </span>
                                        </h5>
                                        <button class="btn btn-primary float-right"
                                            onclick="viewModal(`{{ route('hrm.payroll_setup.item_list', 'type=1&user=' . $data['id']) }}`)">
                                            <i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="card  border-0">
                                        <div class="tab-content px-primary">
                                            <div id="Contract" class="tab-pane active">
                                                <div
                                                    class="content mb-3 mt-3 table-responsive bg-transparent box-shadow-none">
                                                    <table class="table ">
                                                        <thead>
                                                            <tr class="border-bottom-2">
                                                                <th>{{ _trans('common.Title') }}</th>
                                                                <th>{{ _trans('common.Type') }}</th>
                                                                <th>{{ _trans('common.Amount') }}</th>
                                                                <th>{{ _trans('common.Status') }}</th>
                                                                <th>{{ _trans('common.Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $salary_commission = @$data['show']->original['data']['salary_commission'];
                                                            @endphp
                                                            @if (@$salary_commission->salarySetupAdditionDetails)
                                                                @foreach (@$salary_commission->salarySetupAdditionDetails as $setupDetails)
                                                                    <tr>
                                                                        <td>{{ @$setupDetails->commission->name }}</td>
                                                                        <td>
                                                                            @if (@$setupDetails->amount_type == 1)
                                                                                <span
                                                                                    class="badge badge-success">{{ _trans('common.Fixed') }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-info">{{ _trans('common.Percentage') }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (@$setupDetails->amount_type == 1)
                                                                                {{ showAmount(@$setupDetails->amount) }}
                                                                            @else
                                                                                {{ @$setupDetails->amount }}%
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge badge-{{ $setupDetails->status->class }}">{{ $setupDetails->status->name }}</span>
                                                                        </td>
                                                                        <td>
                                                                            @if (hasPermission('edit_payroll_set'))
                                                                                <button class="btn btn-success btn-sm"
                                                                                    onclick="viewModal(`{{ route('hrm.payroll_setup.edit_salary_setup', $setupDetails->id) }}`)">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if (hasPermission('delete_payroll_set'))
                                                                                <button class="btn btn-danger btn-sm"
                                                                                    onclick="delete_item(`{{ route('hrm.payroll_setup.delete_salary_setup', $setupDetails->id) }}`)">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            @endif

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr class="text-center">
                                                                    <td colspan="4">No Data</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between pb-3">
                                        <h5 class="d-flex align-items-center text-capitalize mb-0 title">
                                            <span class="pl-2">{{ _trans('Deduction') }} </span>
                                        </h5>
                                        <button class="btn btn-primary float-right"
                                            onclick="viewModal(`{{ route('hrm.payroll_setup.item_list', 'type=2&user=' . $data['id']) }}`)">
                                            <i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="card  border-0">
                                        <div class="tab-content px-primary">
                                            <div id="Contract" class="tab-pane active">
                                                <div
                                                    class="content mb-3 mt-3 table-responsive bg-transparent box-shadow-none">
                                                    <table class="table ">
                                                        <thead>
                                                            <tr class="border-bottom-2">
                                                                <th>{{ _trans('common.Title') }}</th>
                                                                <th>{{ _trans('common.Type') }}</th>
                                                                <th>{{ _trans('common.Amount') }}</th>
                                                                <th>{{ _trans('common.Status') }}</th>
                                                                <th>{{ _trans('common.Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (@$salary_commission->salarySetupDeductionDetails)
                                                                @foreach (@$salary_commission->salarySetupDeductionDetails as $setupDetails)
                                                                    <tr>
                                                                        <td>{{ @$setupDetails->commission->name }}</td>
                                                                        <td>
                                                                            @if (@$setupDetails->amount_type == 1)
                                                                                <span
                                                                                    class="badge badge-success">{{ _trans('common.Fixed') }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-info">{{ _trans('common.Percentage') }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (@$setupDetails->amount_type == 1)
                                                                                {{ currency_format(@$setupDetails->amount) }}
                                                                            @else
                                                                                {{ @$setupDetails->amount }}%
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge badge-{{ $setupDetails->status->class }}">{{ $setupDetails->status->name }}</span>
                                                                        </td>
                                                                        <td class="Action">
                                                                            @if (hasPermission('edit_payroll_set'))
                                                                                <button class="btn btn-success btn-sm"
                                                                                    onclick="viewModal(`{{ route('hrm.payroll_setup.edit_salary_setup', $setupDetails->id) }}`)">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if (hasPermission('delete_payroll_set'))
                                                                                <button class="btn btn-danger btn-sm"
                                                                                    onclick="delete_item(`{{ route('hrm.payroll_setup.delete_salary_setup', $setupDetails->id) }}`)">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr class="text-center">
                                                                    <td colspan="4">No Data</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ url('public/backend/js/pages/__profile.js') }}"></script>
@endsection
