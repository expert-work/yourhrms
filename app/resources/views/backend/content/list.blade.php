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
                </div>


                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 content_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Title') }}</th>
                                    <th>{{ _translate('Slug') }}</th>
                                    {{-- <th>{{ _trans('common.Status') }}</th> --}}
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <input type="text" hidden id="content_data_url" value="{{ route('dataTable.content') }}">

@endsection

@section('script')
    @include('backend.partials.datatable')

@endsection
