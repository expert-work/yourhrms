@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0">
            @include('backend.partials.staff_navbar')
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="main-panel">
                    <div class="vertical-tab">
                        <div class="row no-gutters">
                            <div class="col-12 pl-md-3 pt-md-0 pt-sm-4 pt-4">

                                @if (url()->current() === route('staff.profile.info','contract'))
                                  
                                    <div class="card  border-0">
                                        <div class="tab-content px-primary">
                                            <div id="Contract" class="tab-pane active">
                                                <div class="content mb-3">
                                                        <input type="text" hidden name="user_id" value="{{ $data['id'] }}">
                                                        <div class="card-body" data-select2-id="698">
                                                            <div class="row">
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('common.Contract Date') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ showDate(@$data['show']->original['data']['contract_start_date'] ) }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('common.Contract End') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ showDate($data['show']->original['data']['contract_end_date']) }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('common.Basic Salary') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ showAmount($data['show']->original['data']['basic_salary']) }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('payroll.Payslip Type') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ _trans('payroll.Per Month') }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('payroll.Late Check In') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ @$data['show']->original['data']['late_check_in'] }} {{_trans('common.Days')}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('payroll.Late Check out') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ @$data['show']->original['data']['early_check_out'] }} {{_trans('common.Days')}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('payroll.Extra Leave') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ @$data['show']->original['data']['monthly_leave'] }} {{_trans('common.Days')}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 d-flex">
                                                                    <div class="col-lg-6">
                                                                        <div class="text-bold" for="">{{ _trans('payroll.Monthly Leave') }}</div> 
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <p>{{ @$data['show']->original['data']['monthly_leave'] }} {{_trans('common.Days')}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                               

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ url('public/backend/js/pages/__profile.js') }}"></script>
@endsection
