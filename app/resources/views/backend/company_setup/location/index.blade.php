@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">

                <div class="row align-items-center mb-15">
                    <div class="col-sm-6 col-12">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>

                    <div class="col-sm-6 col-12">
                        @if(hasPermission('location_create'))
                            <a href="{{ route('company.settings.locationCreate') }}"
                               class="btn btn-primary float-right float-left-sm-device"> <i class="fa fa-plus-square"></i> {{ _trans('common.Create') }}</a>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 location_bind_list_datatable">
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
        </section>

    </div>
    <input type="text" hidden id="location_bind_list_data_url" value="{{ route('company.settings.locationDatatable') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
