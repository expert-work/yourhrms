@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
                    <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    @if (@$data['commission'])
                        <a href="{{ route('hrm.payroll_items.index') }}" class="btn btn-primary "> <i
                                class="fa fa-arrow-left pr-2"></i> {{ _trans('common.Back') }}</a>                        
                    @endif
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-md-4 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ $data['url'] }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">{{ _trans('common.Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Name"
                                            value="{{ @$data['commission'] ? $data['commission']->name : old('name') }}"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group select2-parent-div">
                                        <select name="type" class="form-control select2" required>
                                            <option value="1"
                                                {{ @$data['commission'] ? ($data['commission']->type == 1 ? 'Selected' : '') : '' }}>
                                                {{ _trans('payroll.Addition') }}</option>
                                            <option value="2"
                                                {{ @$data['commission'] ? ($data['commission']->type == 2 ? 'Selected' : '') : '' }}>
                                                {{ _trans('payroll.Deduction') }}</option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group select2-parent-div">
                                        <select name="status" class="form-control select2" required>
                                            <option value="1"
                                                {{ @$data['commission'] ? ($data['commission']->status_id == 1 ? 'Selected' : '') : '' }}>
                                                {{ _trans('payroll.Active') }}</option>
                                            <option value="4"
                                                {{ @$data['commission'] ? ($data['commission']->status_id == 4 ? 'Selected' : '') : '' }}>
                                                {{ _trans('payroll.Inactive') }}</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group text-right">
                                        @if ($data['is_permission'])
                                            <button type="submit"
                                                class="btn btn-primary pull-right"><b>{{ _trans('common.Submit') }}</b></button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <table id="table"
                                    class="table card-table table-vcenter datatable mb-0 w-100 payroll_items_table">
                                    <thead>
                                        <tr>
                                            <th>{{ _trans('common.Name') }}</th>
                                            <th>{{ _trans('common.Type') }}</th>
                                            <th>{{ _trans('common.Status') }}</th>
                                            <th class="">{{ _trans('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <input type="text" hidden id="payroll_items_data_url" value="{{ route('hrm.payroll_items.datatable') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
