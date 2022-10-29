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
                @if (hasPermission('leave_assign_read'))
                    <div class="form-group mb-2 mr-2">
                        <select name="department_id" id="department_id" class="form-control select2">
                            <option value="">{{ _trans('common.Choose One') }}</option>
                            @foreach ($data['departments'] as $department)
                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2 mr-2">
                        <button type="submit" class="btn btn-primary assign_leave_table_search_form">{{ _trans('common.Submit') }}</button>
                    </div>
                @endif
                @if (hasPermission('leave_assign_create'))
                <a href="{{ route('assignLeave.create') }}"
                    class="btn btn-sm btn-primary mb-2">{{ $data['title'] }}
                </a>
            @endif
                </div>
                </div>

                @if (hasPermission('leave_assign_read'))
                    <div class="row dataTable-btButtons">
                        <div class="col-lg-12">
                            <table id="table"
                                class="table card-table table-vcenter datatable mb-0 w-100 assign_leave_table">
                                <thead>
                                    <tr>
                                        <th>{{ _trans('common.Department') }}</th>
                                        <th>{{ _trans('common.Type') }}</th>
                                        <th>{{ _trans('common.Days') }}</th>
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
    <input type="hidden" name="" id="assign_leave_data_url" value="{{ route('assignLeave.dataTable') }}">
@endsection

@section('script')
    @include('backend.partials.datatable')
@endsection
