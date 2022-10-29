@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">


        <!-- Main content -->
        <section class="content p-0 ">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30 ">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                        <div class="d-flex align-items-center flex-wrap">
                            @if (hasPermission('client_read'))
                                <div class="form-group mb-2 mr-2">
                                    <x-date-picker :label="'Date Range'" />
                                    {{-- <input type="date" id="start" name="start_date" class="form-control" value="{{ date('Y-m-d') }}"> --}}
                                </div>
                                <div class="form-group mr-2 mb-2">
                                    <button type="button" class="btn btn-primary client_table_form">{{ _trans('common.Search') }}</button>
                                </div>
                            @endif
                                @if (hasPermission('client_create'))
                                    <div class="form-group mr-2 mb-2">
                                        <a href="{{ route('client.create') }}" class="btn btn-primary "> 
                                            <i class="fa fa-plus-square pr-2"></i> {{ _trans('common.Create') }}</a>
                                    </div>
                                @endif
                        </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 client_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Name') }}</th>
                                    <th>{{ _trans('common.Email') }}</th>
                                    <th>{{ _trans('common.Phone') }}</th>
                                    <th>{{ _trans('client.Website') }}</th>
                                    {{-- <th>{{ _trans('common.File') }}</th> --}}
                                    <th>{{ _trans('common.Status') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            </div>
        </section>
    </div>
    <input type="text" hidden id="client_data_url" value="{{ route('client.datatable') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
