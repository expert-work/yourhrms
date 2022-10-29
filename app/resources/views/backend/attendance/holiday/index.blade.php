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
                        @if(hasPermission('leave_type_create'))
                            <a href="{{ route('holidaySetup.create') }}" class="btn btn-sm btn-primary float-left-sm-device float-right">Add
                                Holiday</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if(hasPermission('holiday_read'))
                        <div class="table-responsive pl-3 pr-3">
                            <table id="table" class="table datatable card-table mb-0 w-100">
                                <thead>
                                <tr>
                                    <th>{{ _trans('common.Title') }}</th>
                                    <th>{{ _trans('common.Description') }}</th>
                                    <th>{{ _trans('common.File') }}</th>
                                    <th>{{ _trans('common.Start date') }}</th>
                                    <th>{{ _trans('common.End date') }}</th>
                                   <th>{{ _trans('common.Status') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['holidays'] as $day)
                                    <tr>
                                        <td>{{ ucfirst($day->title) }}</td>
                                        <td>{{ ucfirst($day->description) }}</td>
                                        <td>
                                            <a href="{{ uploaded_asset($day->attachment_id) }}" class="badge badge-info"
                                               target="_blank">
                                                <i class="fa fa-file-alt"></i>
                                            </a>
                                        </td>
                                        <td>{{ showDate($day->start_date) }} {{  $day->attachment_id }}</td>
                                        <td>{{ showDate($day->end_date) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $day->status->class }}">{{ $day->status_id == 1?'Active':'Inactive' }}</span>
                                        </td>
                                        <td>
                                            <div class="flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('holidaySetup.show',$day->id) }}"
                                                           class="dropdown-item">
                                                            {{ _trans('common.Edit') }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item"
                                                           onclick="__globalDelete({{ $day->id }},`hrm/holiday/setup/delete/`)">
                                                            {{ _trans('common.Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
