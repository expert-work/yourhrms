@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row align-items-center mb-15">
                    <div class="col-sm-6">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>

                    <div class="col-sm-6">
                    </div>
                </div>
                <div class="row align-items-end mb-30 table-filter-data">
                    <div class="col-lg-12">
                        @if (hasPermission('role_read'))
                           <form method="GET" action="" >
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <select name="user" class="form-control select2">
                                                <option value="">{{ _trans('common.Choose One') }}</option>
                                                @foreach ($data['users'] as $user)
                                                    <option {{ @$data['user'] == $user->id ? 'selected="selected"' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <input type="date" id="start" name="date" class="form-control"
                                                value="{{ isset($_GET['date']) ? $_GET['date'] : date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary attendance_table_form">{{ _trans('common.Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <div class="ltn__map-area">
                            <div class="ltn__map-inner">
                              <div id="map" style="height: 500px;"></div>
                              <div class="mt-5" id="directions_panel"></div>
                            </div>
                          </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <input type="text" hidden id="data_url" value="{{ route('locationReportHistory.index','date='. @$data['date'].'&user='. @$data['user']) }}">
    <input type="text" hidden id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
<script src="https://maps.googleapis.com/maps/api/js?key={{ @settings('google') }}"></script>
<script src="{{ asset('public/backend/js/__location_history.js') }}"></script>
@endsection
