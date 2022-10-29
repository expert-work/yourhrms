@extends('backend.layouts.app')
@section('title',  _translate('Income/Expense List'))
@section('content')

    <div class="content-wrapper has-table-with-td">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ @$data['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ _trans('common.Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-sm-right">
                                <a href="{{ route('income_expense.create') }}"
                                    class="btn btn-primary">{{ _translate('Add Income-Expense') }}</a>
                            </div>

                        </div>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ _trans('common.Start Date') }}</label>
                                    <input type="date" id="start" name="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ _trans('common.End Date') }}</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3 filter-btn-margin">
                                <div class="form-group mt-2">
                                    <button type="submit" class="btn btn-primary income_expense_table_form">{{_translate('Filter')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 income_expense_table">
                            <thead>
                                <tr>
                                    <th>{{ _translate('SL') }}</th>
                                    <th>{{ _translate('Date') }}</th>
                                    <th>{{ _translate('User') }}</th>
                                    <th>{{ _translate('Type') }}</th>
                                    <th>{{ _translate('Category') }}</th>
                                    <th>{{ _translate('Amount') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>>{{ _translate('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
<input type="text" hidden id="data_url" value="{{ @$data['url']}}"
@endsection
@section('script')
@include('backend.partials.datatable')
@endsection
