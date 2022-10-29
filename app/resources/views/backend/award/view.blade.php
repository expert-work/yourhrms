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
                            @if (hasPermission('award_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('award.index') }}">{{ _trans('common.List') }}</a>
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
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="panel_s">
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-md-8 border-right project-overview-left">
                                                @if (@$data['view']->attachment)                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table project-overview-table">
                                                                <tbody>
                                                                    <div class="project-overview-id">
                                                                        <div class="mb-2">
                                                                            <img class="img-responsive"
                                                                                src="{{ uploaded_asset($data['view']->attachment) }}"
                                                                                alt="">
                                                                        </div>
                                                                    </div>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="tc-content project-overview-description font-size-13">
                                                    <p class="bold font-size-16 project-info">
                                                        {{ _trans('common.Description') }}
                                                    </p>
                                                    <?= $data['view']->description ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 project-overview-right">
                                                <table class="table project-overview-table">
                                                    <tbody>
                                                        <tr class="project-overview-status">
                                                            <td class="bold">{{ _trans('common.Employee') }}</td>
                                                            <td>{{ @$data['view']->user->name }}</td>
                                                        </tr>
                                                        <tr class="project-overview-status">
                                                            <td class="bold">{{ _trans('award.Award Type') }}</td>
                                                            <td>{{ @$data['view']->type->name }}</td>
                                                        </tr>
                                                     
                                                        <tr class="project-overview-status">
                                                            <td class="bold">{{ _trans('award.Gift') }}
                                                            </td>
                                                            <td>
                                                               {{ @$data['view']->gift }}
                                                            </td>
                                                        </tr>
                                                        <tr class="project-overview-date-created">
                                                            <td class="bold">
                                                                {{ _trans('common.Date') }}
                                                            </td>
                                                            <td>{{ showDate($data['view']->created_at) }}</td>
                                                        </tr>
                                                        <tr class="project-overview-start-date">
                                                            <td class="bold">
                                                                {{ _trans('common.Amount') }}
                                                            </td>
                                                            <td>{{ showAmount($data['view']->amount) }}</td>
                                                        </tr>
                                                        <tr class="project-overview-status">
                                                            <td class="bold">{{ _trans('award.Gift Info') }}
                                                            </td>
                                                            <td>
                                                               {{ @$data['view']->gift_info }}
                                                            </td>
                                                        </tr>

                                                        <tr class="project-overview-status">
                                                            <td class="bold">{{ _trans('common.Added By') }}
                                                            </td>
                                                            <td>
                                                               {{ @$data['view']->added->name }}
                                                            </td>
                                                        </tr>


                                                        <tr class="project-overview-deadline">
                                                            <td class="bold">{{ _trans('performance.Goal') }}
                                                            </td>
                                                            <td>{{ @$data['view']->goal->subject?? _trans('performance.No Goal Set') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="text" hidden id="{{ @$data['url_id'] }}" value="{{ @$data['table_url'] }}">
@endsection
@section('script')
    <script src="{{ asset('public/backend/js/pages/__project.js') }}"></script>
    <script src="{{ asset('public/backend/js/pages/__task.js') }}"></script>
@endsection
