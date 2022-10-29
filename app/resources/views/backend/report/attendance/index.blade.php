@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>
                    <div class="col-lg-8 d-flex">
                        <div class="form-group mb-2 mr-2">
                            <input class="daterange-table-filter" type="text" name="daterange" id="daterange"
                                value="{{ date('m/d/Y') }}-{{ date('m/d/Y') }}" />
                        </div>
                        {{-- <div class="form-group mr-2 mb-2">
                            @if (hasPermission('attendance_report_read'))
                            <select name="department" id="department" class="form-control select2">
                                <option value="">Select Department</option>
                                @foreach ($data['departments'] as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach

                            </select>
                            @endif
                        </div> --}}
                        <div class="col-xl-3">
                            <div class="form-group">
                                <select name="department" class="form-control" onchange="department(this.value)">
                                    <option value="" selected disabled>{{ _trans('common.Choose One') }}</option>
                                    @foreach($data['departments'] as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <select name="user_id" class="form-control select2" id="company_employee"
                                    required></select>
                            </div>
                        </div>
                    <div class="form-group mr-2 mb-2">
                        <button type="submit" class="btn btn-primary attendance_table_form">Submit</button>
                    </div>
                    </div>
                </div>
              

                <div class="row dataTable-btButtons attendance-list">
                    <div class="col-lg-12">
                        <table id="table"
                            class="table card-table table-vcenter datatable mb-0 w-100 attendance_report_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Date') }}</th>
                                    <th>{{ _trans('common.Employee') }}</th>
                                    <th>{{ _trans('common.Department') }}</th>
                                     <th>{{ _trans('attendance.Break') }}</th>
                                     <th>{{ _trans('attendance.Break Duration') }}</th>
                                     <th width="25%">{{ _trans('attendance.Check-in') }}</th>
                                     <th width="25%">{{ _trans('attendance.Check-out') }}</th>
                                     <th>{{ _trans('attendance.Hours') }}</th>
                                     <th>{{ _trans('attendance.Overtime') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <input type="text" hidden id="attendance_report_data_url" value="{{ route('attendanceReport.dataTable') }}">
    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
