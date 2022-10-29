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

                <div class="row align-items-end mb-30 table-filter-data">
                    <div class="col-lg-12">
                        @if(hasPermission('role_read'))
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <select name="department" class="form-control select2" id="department"
                                            onchange="onchangeDepartmentWiseuserLoad()">
                                            <option value="">{{ _trans('common.Choose One') }}</option>
                                            @foreach ($data['departments'] as $department)
                                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="selected_department" value="" id="selected_department">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <select name="user_id" class="form-control select2" id="__user_id"
                                                required></select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <input type="date" id="start_date" name="start_date"
                                               class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <input type="date" id="end_date" name="end_date"
                                               class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary break_table_form">Submit</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table"
                               class="table card-table table-vcenter datatable mb-0 w-100 break_report_table">
                            <thead>
                            <tr>
                                <th>{{ _trans('common.Date') }}</th>
                                <th>{{ _trans('common.Employee') }}</th>
                                <th>{{ _trans('common.Department') }}</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Duration</th>
                                <th>{{ _trans('common.Reason') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <input type="hidden" id="break_report_data_url" value="{{ route('breakReport.dataTable') }}">
    <input type="text" hidden id="get_all_user_by_dep_des" value="{{ url('dashboard/user/get-all-user-by-dep-des') }}">
    <input type="text" hidden id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
