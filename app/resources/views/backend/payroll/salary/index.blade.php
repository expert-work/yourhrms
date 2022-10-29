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
                        @if (hasPermission('salary_search'))
                            <div class="form-group mb-2 mr-2">
                                <input type="date" id="start" name="start_date" class="form-control">
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="9">{{ _trans('common.Unpaid') }}</option>
                                    <option value="8">{{ _trans('common.Paid') }}</option>
                                    <option value="20">{{ _trans('common.Partially Paid') }}</option>
                                </select>
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <select name="department" id="department" class="form-control select2">
                                    <option value="0">{{ _trans('common.Choose Department') }}</option>
                                    @foreach ($data['departments'] as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <button type="button"
                                    class="btn btn-primary salary_table_form">{{ _trans('common.Search') }}</button>
                            </div>
                        @endif
                        @if (@$data['salary_generate'])
                            <div class="form-group mr-2 mb-2">
                                <button onclick="mainModalOpen(`{{ @$data['salary_generate'] }}`)"
                                    class="btn btn-primary "> <i class="fa fa-plus-square"></i>
                                    {{ _trans('common.Generate') }}</button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table"
                                    class="table card-table table-vcenter datatable mb-0 w-100 {{ @$data['class'] }}">
                                    <thead>
                                        <tr>
                                            @foreach ($data['fields'] as $field)
                                                <th>{{ $field }}</th>
                                            @endforeach
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
    <input type="text" hidden id="{{ @$data['url_id'] }}" value="{{ @$data['url'] }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
