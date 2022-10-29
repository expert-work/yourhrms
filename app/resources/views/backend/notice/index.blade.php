@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0 ">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30 ">
                <!-- section 01  -->
                <div class="row align-items-center mb-15">
                    <div class="col-sm-6 col-12">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>

                    <div class="col-sm-6 col-12">
                        @if(hasPermission('notice_create'))
                            <a href="{{ route('notice.create') }}" class="btn btn-sm btn-primary float-left-sm-device float-right">Add Notice</a>
                        @endif
                    </div>
                </div>

                <!-- section 02 -->
                <div class="row align-items-end mb-30 table-filter-data">
                  
                </div>

                <!-- section 03  -->
                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 notice_table">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Date') }}</th>
                                     <th>{{ _trans('common.Subject') }}</th>
                                    <th>{{ _trans('common.Department') }}</th>
                                    <th>{{ _trans('common.Description') }}</th>
                                    <th>File</th>
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

    <input type="text" hidden id="notice_data_url" value="{{ route('notice.dataTable') }}">
    {{-- <input type="text" hidden id="user_id" value="{{ auth()->id()}}"> --}}
    <input type="text" hidden id="company_id" value="{{ auth()->user()->company_id}}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
