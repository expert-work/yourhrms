@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">

                {{-- <div class="row align-items-center mb-15">
                    <div class="col-sm-6 col-12">

                    </div>

                    <div class="col-sm-6 col-12">

                    </div>
                </div> --}}
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
                    <h5 class="fm-poppins m-0 text-dark mb-2">{{ @$data['title'] }}</h5>
                    <div class="d-flex align-items-center flex-wrap">
                        {{-- @if(hasPermission('leave_type_read'))

                            <x-date-picker :label="'Start Date'"/>


                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-primary leave_type_table_search_form  mr-2">{{_translate('Submit')}}</button>
                            </div>

                        @endif --}}
                        @if(hasPermission('leave_type_create'))
                        <a href="{{ route('leave.create') }}" class="btn btn-sm btn-primary mb-2">{{ _trans('leave.Add leave type') }}</a>
                    @endif
                    </div>

                </div>

                {{-- <div class="row align-items-end mb-30 table-filter-data justify-content-center">

                </div> --}}

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 leave_type_table">
                            <thead>
                            <tr>
                                 <th>{{ _trans('common.Name') }}</th>
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
    <input type="hidden" name="" id="leave_type_data_url" value="{{ route('leave.dataTable') }}">
@endsection

@section('script')
    @include('backend.partials.datatable')
@endsection
