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
                                <select name="shift" class="form-control select2" id="shift">
                                    <option value="">{{ _trans('common.Choose One') }}</option>
                                    @foreach ($data['shifts'] as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-2 mr-2">
                                <button type="submit" class="btn btn-primary duty_schedule_form">{{ _trans('common.Submit') }}
                                </button>
                            </div>
                        @endif
                        <a class="btn btn-primary mb-2" href="{{ route('dutySchedule.create') }}">{{ _trans('attendance.Add Schedule') }}</a>
                    </div>

                </div>
                <div class="row">
                    @if (hasPermission('schedule_read'))
                        <div class="col-lg-12">
                            <table id="table" class="table card-table datatable mb-0 w-100 duty_schedule_table">
                                <thead>
                                    <tr>
                                        <th>{{ _trans('common.Department') }}</th>
                                        <th>{{ _trans('common.Start Time') }}</th>
                                        <th>{{ _trans('common.End Time') }}</th>
                                        <th>{{ _trans('common.Hours') }}</th>
                                        <th>{{ _trans('attendance.Consider Time') }}</th> 
                                        <th>{{ _trans('common.Status') }}</th>
                                        <th>{{ _trans('common.Action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <input type="text" hidden id="duty_schedule_data_url" value="{{ route('dutySchedule.dataTable') }}">
        </section>
    </div>

@endsection
@section('script')
    @include('backend.partials.datatable')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            @php
                Brian2694\Toastr\Facades\Toastr::warning($error, '');
            @endphp
        @endforeach
    @endif
@endsection
