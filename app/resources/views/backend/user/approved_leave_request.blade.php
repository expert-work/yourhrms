@extends('backend.layouts.app')
@section('title', @$data['title']) 
@section('content')
    <style>
        td {
            text-transform: capitalize;
        }

    </style>
    <div class="content-wrapper dashboard-wrapper mt-30">
        @include('backend.partials.user_navbar')

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                @if(hasPermission('leave_request_read'))
                {{-- <form action="{{ route('leaveRequest.profileDataTable') }}" method="get"> --}}
                <div class="row align-items-end mb-30 table-filter-data">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Type</label>
                            <select name="short_by" class="form-control" id="short_by">
                                <option value="" selected disabled>{{ _trans('common.Choose One') }}</option>
                                <option value="1">Approve</option>
                                <option value="2">Pending</option>
                                <option value="6">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <x-date-picker :label="'Date Range'"/>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary profile_leave_request_table_search_form">{{_translate('Submit')}}</button>
                        </div>
                    </div>
                    @if(auth()->user()->id==$data['id'])
                        <div class="col-lg-3">
                            <div class="form-group">
                                <a href="{{ route('leaveRequest.create') }}" class="btn btn-primary ">{{_translate('Add Leave Request')}}</a>
                            </div>
                        </div>
                    @endif
                </div>
            {{-- </form> --}}
                @endif
                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 profile_leave_request_table">
                            <thead>
                            <tr>
                                {{ _trans('common.Name') }}
                                <th>Leave Type</th>
                                <th>{{ _trans('common.Days') }}</th>
                                <th>Team Leader</th>
                                <th>File</th>
                                <th>{{ _trans('common.Status') }}</th>
                                {{-- <th>{{ _trans('common.Action') }}</th> --}}
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>


    <input type="hidden" name="user_id" id="user_id" value="{{ $data['id']}}">
    <input type="hidden" name="" id="profile_leave_request_data_url" value="{{ route('leaveRequest.profileDataTable') }}">

@endsection

@section('script')
    @include('backend.partials.datatable')
@endsection
