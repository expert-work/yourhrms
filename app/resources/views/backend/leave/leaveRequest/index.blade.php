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
                </div>
                @if(hasPermission('leave_request_read') && hasPermission('leave_request_approve'))
                    <div class="row align-items-end mb-30 table-filter-data justify-content-center">
                        <div class="col-xl-2">
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
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label>{{ _trans('common.Employee') }}</label>
                                <select name="user_id" class="form-control" id="company_employee">

                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="short_by">{{ _trans('common.Type') }}</label>
                                <select name="short_by" class="form-control select2" id="short_by">
                                    <option value="" selected disabled>{{ _trans('common.Choose One') }}</option>
                                    <option value="1">{{ _trans('common.Approve') }}</option>
                                    <option value="2">{{ _trans('common.Pending') }}</option>
                                    <option value="6">{{ _trans('common.Reject') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                {{-- <label for="daterange">Date</label>
                                <input class="daterange-table-filter" type="text" name="daterange" id="daterange"> --}}
                                <x-date-picker :label="'Date Range'"/>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-primary leave_request_table_search_form">{{ _trans('common.Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if(hasPermission('leave_request_read') || hasPermission('team_update'))
                    <div class="row dataTable-btButtons">
                        <div class="col-lg-12">
                            <table id="table"
                                   class="table card-table table-vcenter datatable mb-0 w-100 leave_request_table">
                                <thead>
                                <tr>
                                    <th>{{ _trans('common.Name') }}</th>
                                    <th>{{ _trans('leave.Leave Type') }}</th>
                                    <th>{{ _trans('common.Date') }}</th>
                                    <th>{{ _trans('common.Days') }}</th>
                                    <th>{{ _trans('leave.Available Days') }}</th>
                                    <th>{{ _trans('leave.Substitute') }}</th>
                                    <th>{{ _trans('leave.Manager Approved') }}</th>
                                    <th>{{ _trans('leave.HR Approved') }}</th>
                                    <th>{{ _trans('common.File') }}</th>
                                    <th>{{ _trans('common.Status') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
    <input type="hidden" name="" id="leave_request_data_url" value="{{ $data['url'] }}">
    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">

@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
