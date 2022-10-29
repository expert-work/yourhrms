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
                        @if (hasPermission('leave_type_create'))
                            <a href="{{ route('department.create') }}"
                                class="btn btn-primary mb-2">{{ _trans('common.Add Department') }}</a>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 department_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Title') }}</th>
                                    <th>{{ _trans('common.employees') }}</th>
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
    <input type="text" hidden id="department_data_url" value="{{ route('department.dataTable') }}">
@endsection

@section('script')
    @include('backend.partials.datatable')
@endsection
