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

                    <div class="offset-sm-6 col-sm-6 text-right">
                        
                        @if(hasPermission('user_ip_binding') && checkFeature('user_location_binds'))
                            <a type="button" href="{{ route('ipConfig.UserWise') }}" class="btn btn-primary"><i class="bi bi-card-checklist"></i> {{ _trans('settings.User IP Bind') }}</a>
                        @endif
                        <a type="button" href="{{ route('ipConfig.create') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> {{ _trans('common.Create') }}</a>

                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 ip_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Location') }}</th>
                                    <th>{{ _trans('common.IP Address')}}</th>
                                    <th>{{ _trans('common.Status') }}</th>
                                    <th>{{ _trans('common.Is Office') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <input type="text" hidden id="ip_list_data_url" value="{{ route('ipConfig.datatable') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
