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
                        @if (hasPermission('role_read'))
                            <div class="form-group mb-2 mr-2">
                                {{-- <label for="">Start Date</label> --}}
                                <input class="daterange-table-filter" type="text" name="daterange"
                                    value="01/01/2018 - 01/15/2018" />
                            </div>
                            <div class="form-group mb-2 mr-2">
                                <button type="submit" class="btn btn-primary roles_table_form">{{ _trans('common.Submit') }}</button>
                            </div>
                        @endif
                        
                        @if (hasPermission('role_create'))
                            <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">{{ _trans('common.Add Role') }}  </a>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 roles_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Name') }}</th>
                                    <th>{{ _trans('common.Permission') }}</th>
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
    <input type="text" hidden id="roles_data_url" value="{{ route('roles.dataTable') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
