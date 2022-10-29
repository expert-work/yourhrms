@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30">
    @include('backend.partials.user_navbar')

    <!-- Main content -->
        <section class="content p-0 has-table-with-td">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row align-items-center mb-15">
                    <div class="col-sm-6">
                        {{-- <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5> --}}
                    </div>
                    
                    <div class="col-sm-6 d-flex">
                        <div class="col-lg-6">
                            <div class="form-group mb-2 mr-2">
                                <input class="daterange-table-filter" type="text" name="daterange" id="daterange"
                                    value="{{ date('m/d/Y') }}-{{ date('m/d/Y') }}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mr-2 mb-2">
                                <button type="submit" class="btn btn-primary attendance_table_form">Submit</button>
                            </div>
                        </div>
                        {{-- <div class="float-sm-right">
                            <a href="{{ route('attendance.check-in') }}" class="btn btn-primary">Add attendance</a>
                        </div> --}}
                    </div>
                </div>
                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table"
                               class="table card-table table-vcenter datatable mb-0 w-100 attendance_report_table">
                            <thead>
                            <tr>
                                <th>{{ _trans('common.Date') }}</th>
                                <th>{{ _trans('common.Employee') }}</th>
                                <th>{{ _trans('common.Department') }}</th>
                                <th>Break Count</th>
                                 <th>{{ _trans('attendance.Break Duration') }}</th>
                                 <th>{{ _trans('attendance.Check in') }}</th>
                                 <th>{{ _trans('attendance.Check Out') }}</th>
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

    <input type="hidden" name="" id="attendance_report_data_url" value="{{ @$data['url'] }}">
    <input type="hidden" name="" id="__user_id" value="{{ @$data['id'] }}">

@endsection

@section('script')
    @include('backend.partials.datatable')
@endsection
