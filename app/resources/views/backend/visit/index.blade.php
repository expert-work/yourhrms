@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row align-items-center mb-15">
                    <div class="col-sm-6">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
                <div class="row align-items-center mb-15">
                    <div class="col-lg-12">
                        @if (hasPermission('role_read'))
                            <div class="row justify-content-center">
                                <div class="col-xl-3">
                                    <label for="department_id">{{  _trans('common.Daterange') }}</label>
                                    <x-date-picker :label="_trans('common.Daterange')" />
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label for="department_id">{{  _trans('common.Status') }}</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">{{ _trans('common.Status') }}</option>
                                            @foreach (config()->get('app.visit_status') as $status_key => $status)
                                                <option value="{{ $status_key }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="department_id">{{  _trans('common.Department') }}</label>
                                        <select name="department_id" class="form-control" onchange="department(this.value)">
                                            <option value="" selected disabled>{{ _trans('common.Choose One') }}</option>
                                            @foreach($data['departments'] as $department)
                                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label for="department_id">{{  _trans('common.Employee') }} <span id="visit_employee" class="text-danger d-none">*</span> </label>
                                        <select name="user_id" class="form-control select2" id="company_employee" required>
                                            <option value="">{{ _trans('common.Select Employee') }} *</option>
                                        </select>
                                        <span id="employee_select_msg" class="text-danger d-none">Please Select Specific Employee </span>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group mt-30">
                                        <button type="submit" class="btn btn-primary visit_table_form">{{ _trans('common.Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table"
                            class="table card-table table-vcenter datatable mb-0 w-100 visit_report_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Employee') }}</th>
                                    <th>{{ _trans('common.Date') }}</th>
                                    <th>{{ _trans('common.Title') }}</th>
                                    <th>{{ _trans('common.Description') }}</th>
                                    <th>{{ _trans('common.Cancellation note') }}</th>
                                    <th>{{ _trans('common.File') }}</th>
                                    <th>{{ _trans('common.Status') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="text" hidden id="visit_report_table_url" value="{{ route('visit.history.dataTable') }}">
    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
    <input type="text" hidden id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
