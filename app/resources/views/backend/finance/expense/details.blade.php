@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ @$data['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard') }}">{{ _translate('Dashboard') }}</a></li>
                            @if (hasPermission('advance_salaries_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('hrm.payroll_advance_salary.index') }}">{{ _trans('common.List') }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    {{-- Start summary overview --}}
                    <div class="col-md-12">
                        <div class="card card-with-shadow border-0">
                            <div class="px-primary py-primary">
                                {{-- Summary  start --}}
                                <div id="General-0">
                                    <h4>
                                        @include('backend.auth.hrm_logo')
                                    </h4>
                                    <hr>
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="black12">
                                        <tbody>
                                            <tr>
                                                <td align="left" valign="middle" class="black12">
                                                    {{ _trans('common.Employee') }}</td>
                                                <td align="center" valign="middle" class="black12">:</td>
                                                <td align="left" valign="middle">
                                                    {{ @$data['show']->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle" class="black12">
                                                    {{ _trans('common.Designation') }}</td>
                                                <td align="center" valign="middle" class="black12">:</td>
                                                <td align="left" valign="middle">
                                                    {{ @$data['show']->user->designation->title }}</td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle" class="black12">
                                                    {{ _trans('common.Date') }}</td>
                                                <td align="center" valign="middle" class="black12">:</td>
                                                <td align="left" valign="middle">
                                                    {{ main_date_format(@$data['show']->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle" class="black12">
                                                    {{ _trans('common.Reason') }}</td>
                                                <td align="center" valign="middle" class="black12">:</td>
                                                <td align="left" valign="middle">
                                                    {{ @$data['show']->remarks }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle" class="black12">
                                                    {{ _trans('common.Status') }}</td>
                                                <td align="center" valign="middle" class="black12">:</td>
                                                <td align="left" valign="middle">
                                                    <?= '<small class="badge badge-' . @$data['show']->status->class . '">' . @$data['show']->status->name . '</small>' ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle" class="black12">
                                                    {{ _trans('common.Payment') }}</td>
                                                <td align="center" valign="middle" class="black12">:</td>
                                                <td align="left" valign="middle">
                                                    <?= '<small class="badge badge-' . @$data['show']->payment->class . '">' . @$data['show']->payment->name . '</small>' ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table mb-0">
                                        <thead class="card-header-invoice header-color">
                                            <tr>
                                                <td colspan="5" class="w-350 text-start"><strong>
                                                        {{ _trans('common.Title') }} </strong></td>
                                                <td colspan="5" class="w-350 text-end"><strong>
                                                        {{ _trans('common.Amount') }} </strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="w-350 text-start">
                                                    {{ @$data['show']->category->name }} [
                                                    <?= '<small class="text-danger">' . _trans('payroll.Expense') . '</small>' ?>]
                                                </td>
                                                <td colspan="5" class="w-350 text-end">
                                                    <span class="text-dark">
                                                        {{ currency_format(number_format(@$data['show']->amount, 2)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        <tfoot class="card-footer-invoice border-none">
                                            <tr>
                                                <td class="text-end border-bottom-0" colspan="8">
                                                    <strong>{{ _trans('common.Total') }}:</strong>
                                                </td>
                                                <td class="text-end border-bottom-0" colspan="8">
                                                    {{ currency_format(number_format(@$data['show']->amount, 2)) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <footer class="text-center mt-4">
                                    <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()"
                                            class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a>  </div>
                                </footer>

                                {{-- Summary end --}}
                            </div>
                        </div>
                    </div>
                    {{-- End summary overview --}}
                </div>
            </div>
        </section>
    </div>

@endsection
