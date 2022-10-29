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

                <div class="row align-items-end mb-30 table-filter-data justify-content-center">
                    @if(hasPermission('expense_read'))
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">{{ _trans('expense.Purpose') }}</label>
                                <select name="purpose" id="category_id" multiple class="form-control select2">
                                    @foreach($data['purposes'] as $purpose)
                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">{{ _trans('common.Employees') }}</label>
                                <select name="purpose" id="employee_id" multiple class="form-control select2">
                                    @foreach($data['employees'] as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">{{ _trans('common.Start Date') }}</label>
                                {{-- <input class="daterange-table-filter" type="text" name="daterange" id="daterange"
                                       value="{{ date('m/d/Y') }}-{{ date('m/d/Y') }}"/> --}}
                                       <x-date-picker :label="'Date Range'" />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">{{ _trans('common.Time Picker') }}</label>
                                <input class="daterange-table-filter" type="text"  name="timepicker" id="timepicker"
                                />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary expense_table_form">{{ _trans('common.Submit') }}</button>
                            </div>
                        </div>
                    @endif
                </div>

                @if(hasPermission('expense_read'))
                    <div class="row dataTable-btButtons">
                        <div class="col-lg-12">
                            <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 expense_table">
                                <thead>
                                <tr>
                                    <th>{{ _trans('common.Date') }}</th>
                                    <th>{{ _trans('common.Employee name') }}</th>
                                    <th>{{ _trans('common.Amount') }}</th>
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
    <input type="hidden" name="" id="expense_list_data_url" value="{{ route('expense.dataTable') }}">
@endsection

@section('script')
    @include('backend.partials.datatable')
@endsection
