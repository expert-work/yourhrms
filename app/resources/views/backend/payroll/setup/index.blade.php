@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
                    <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    <div class="d-flex align-items-center flex-wrap">
                        @if (hasPermission('advance_salaries_search'))
                            <div class="form-group mr-2 mb-2">
                                <select name="department" id="department" class="form-control select2"
                                    onchange="departmentUsers()">
                                    <option value="0">{{ _trans('common.Choose Department') }}</option>
                                    @foreach ($data['departments'] as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <select name="user_id" class="form-control select2" id="__user_id" required>
                                    <option value="0">{{ _trans('common.Choose Employee') }}</option>
                                </select>
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <button type="button"
                                    class="btn btn-primary setup_table_form">{{ _trans('common.Search') }}</button>
                            </div>
                        @endif
                        @if (hasPermission('list_payroll_item'))
                            <div class="form-group mr-2 mb-2">
                                <a href="{{ route('hrm.payroll_items.index') }}" class="btn btn-primary">
                                    <span> {{ _trans('payroll.Item List') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table"
                                    class="table card-table table-vcenter datatable mb-0 w-100 payroll_setup_table">
                                    <thead>
                                        <tr>
                                            <th>{{ _trans('common.Employee') }} {{ _trans('common.ID') }} </th>
                                            <th>{{ _trans('common.Employee') }}</th>
                                            <th>{{ _trans('common.Designation') }}</th>
                                            <th>{{ _trans('common.Department') }}</th>
                                            <th>{{ _trans('common.Shift') }}</th>
                                            <th>{{ _trans('common.Basic Salary') }}</th>
                                            <th>{{ _trans('common.Status') }}</th>
                                            <th class="">{{ _trans('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <input type="text" hidden id="payroll_setup_data_url" value="{{ route('hrm.payroll_setup.datatable') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
