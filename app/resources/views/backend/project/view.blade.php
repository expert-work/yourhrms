@extends('backend.layouts.app')
@section('title', @$title)
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ @$title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard') }}">{{ _translate('Dashboard') }}</a></li>
                            @if (hasPermission('project_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('project.index') }}">{{ _trans('common.List') }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active">{{ @$title }}</li>
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
                            @include('backend.project.tab')
                        </div>
                        <div class="card">

                            <div class="card-body">
                                @if (url()->current() === route('project.view', [$data['view']->id, 'overview']) && hasPermission('project_view'))
                                    <div class="panel_s">
                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="col-md-6 border-right project-overview-left">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                                                <h6 class="project-info bold font-size-14">
                                                                    {{ _trans('project.Overview') }}</h6>
                                                                <div class="d-flex align-items-center flex-wrap">
                                                                    @if (hasPermission('project_complete') && $data['view']->status_id != 27)
                                                                        <div class="form-group mr-2 mb-2">
                                                                            <a onclick="GlobalApprove(`{{ route('project.complete', '&project_id=' . $data['view']->id) }}`, `{{ _trans('project.Project Complete') }}` )"
                                                                                href="javascript:;"
                                                                                class="btn btn-primary "> <i
                                                                                    class="fa fa-check"></i></a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <table class="table project-overview-table">
                                                                <tbody>
                                                                    <tr class="project-overview-id">
                                                                        <td class="bold">{{ _trans('project.Project') }}
                                                                            #
                                                                        </td>
                                                                        <td> {{ @$data['view']->name }} </td>
                                                                    </tr>
                                                                    <tr class="project-overview-customer">
                                                                        <td class="bold">Customer</td>
                                                                        <td>
                                                                            {{ @$data['view']->client->name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="project-overview-billing">
                                                                        <td class="bold">Billing Type</td>
                                                                        <td>
                                                                            {{ @$data['view']->billing_type == 'fixed' ? _trans('project.Fixed Rate') : _trans('project.Project Hours') }}
                                                                        </td>
                                                                    </tr>
                                                                    @if (@$data['view']->billing_type == 'fixed')
                                                                        <tr class="project-overview-amount">
                                                                            <td class="bold">
                                                                                {{ _trans('project.Total Rate') }}
                                                                            </td>
                                                                            <td> {{ showAmount(@$data['view']->total_rate) }}
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr class="project-overview-amount">
                                                                            <td class="bold">
                                                                                {{ _trans('project.Per Rate') }}
                                                                            </td>
                                                                            <td> {{ showAmount(@$data['view']->per_rate) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr> </tr>
                                                                    <tr class="project-overview-status">
                                                                        <td class="bold">{{ _trans('common.Status') }}
                                                                        </td>
                                                                        <td>
                                                                            <?= '<small class="badge badge-' . @$data['view']->status->class . '">' . @$data['view']->status->name . '</small>' ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="project-overview-date-created">
                                                                        <td class="bold">
                                                                            {{ _trans('common.Date Created') }}
                                                                        </td>
                                                                        <td>{{ showDate($data['view']->created_at) }}</td>
                                                                    </tr>
                                                                    <tr class="project-overview-start-date">
                                                                        <td class="bold">
                                                                            {{ _trans('common.Start Date') }}
                                                                        </td>
                                                                        <td>{{ showDate($data['view']->start_date) }}</td>
                                                                    </tr>
                                                                    <tr class="project-overview-deadline">
                                                                        <td class="bold">{{ _trans('project.Deadline') }}
                                                                        </td>
                                                                        <td>{{ showDate($data['view']->end_date) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            {{ _trans('project.Project Progress') }}
                                                                            {{ $data['view']->progress }}%
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                class="progress no-margin progress-bar-mini">
                                                                                <div class="progress-bar progress-bar-success no-percent-text not-dynamic"
                                                                                    role="progressbar"
                                                                                    aria-valuenow="{{ $data['view']->progress }}"
                                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                                    style="width: {{ $data['view']->progress }}%;"
                                                                                    data-percent="{{ $data['view']->progress }}">
                                                                                </div>
                                                                            </div>
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
                                                    <div class="clearfix"></div>
                                                    <div class="tc-content project-overview-description font-size-13">
                                                        <hr class="hr-panel-heading project-area-separation">
                                                        <p class="bold font-size-16 project-info">
                                                            {{ _trans('common.Description') }}
                                                        </p>
                                                        <?= $data['view']->description ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 project-overview-right">
                                                    <div class="row">
                                                        <div class="col-md-6 project-progress-bars">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="info-box bg-info">
                                                                        <span class="info-box-icon"><i
                                                                                class="fa fa-check-circle"
                                                                                aria-hidden="true"></i></span>
                                                                        <div class="info-box-content">
                                                                            <span class="info-box-text">Tasks</span>
                                                                            <span class="info-box-number">
                                                                                <span dir="ltr">11 / 15</span>
                                                                            </span>
                                                                            <div class="progress">
                                                                                <div class="progress-bar"
                                                                                    style="width: 70%">
                                                                                </div>
                                                                            </div>
                                                                            <span class="progress-description">
                                                                                70% Increase
                                                                            </span>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-6 project-progress-bars project-overview-days-left">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="info-box bg-olive">
                                                                        <span class="info-box-icon"><i
                                                                                class="far fa-calendar-check"></i></span>
                                                                        <div class="info-box-content">
                                                                            <span
                                                                                class="info-box-text">{{ _trans('project.Days Left') }}</span>
                                                                            <span class="info-box-number">
                                                                                {{-- now()->diffInDays(\Carbon\Carbon::parse($data['view']->end_date) --}}
                                                                                <span dir="ltr">
                                                                                    {{ date_diff_days($data['view']->start_date) }}
                                                                                    /
                                                                                    {{ date_diff_days($data['view']->end_date) }}</span>
                                                                            </span>

                                                                            <div class="progress">
                                                                                <div class="progress-bar"
                                                                                    style="width: {{ date_diff_days($data['view']->start_date, $data['view']->end_date) - date_diff_days($data['view']->end_date) }}%">
                                                                                </div>
                                                                            </div>
                                                                            <span class="progress-description">
                                                                                {{ date_diff_days($data['view']->start_date, $data['view']->end_date) - date_diff_days($data['view']->end_date) }}%
                                                                                Increase
                                                                            </span>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="hr-panel-heading">
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <div class="info-box">
                                                                <div class="info-box-content">
                                                                    <span
                                                                        class="info-box-text">{{ _trans('project.Total Expenses') }}</span>
                                                                    <span class="info-box-number">
                                                                        {{ showAmount($data['view']->amount) }}
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="info-box">
                                                                <div class="info-box-content">
                                                                    <span
                                                                        class="info-box-text">{{ _trans('project.Billed Expenses') }}</span>
                                                                    <span class="info-box-number">
                                                                        {{ showAmount($data['view']->paid) }}
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="info-box">
                                                                <div class="info-box-content">
                                                                    <span
                                                                        class="info-box-text">{{ _trans('project.Unbilled Expenses') }}</span>
                                                                    <span class="info-box-number">
                                                                        {{ showAmount($data['view']->due) }}
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (url()->current() === route('project.view', [$data['view']->id, 'discussions']) && hasPermission('project_discussion_list'))
                                    @if ($data['table'])
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                            <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                            <div class="d-flex align-items-center flex-wrap">
                                                @if (hasPermission('discussion_create'))
                                                    <div class="form-group mr-2 mb-2">
                                                        <a onclick="viewModal(`{{ route('project.discussion.create', 'project_id=' . $data['view']->id) }}`)"
                                                            href="javascript:;" class="btn btn-primary "> <i
                                                                class="fa fa-plus-square pr-2"></i>
                                                            {{ _trans('common.Create') }}</a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row dataTable-btButtons">
                                            <div class="col-lg-12">
                                                @include('backend.partials.tablePartial')
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                            <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                        </div>

                                        <div class="panel_s">
                                            <div class="panel-body font-size-13">
                                                <h3 class="bold no-margin font-size-14">
                                                    {{ @$data['discussion']->subject }}
                                                </h3>
                                                <hr>
                                                <?= $data['discussion']->description ?>
                                                <br>
                                                <br>
                                                <small class="font-size-13">{{ _trans('project.Posted on') }}
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['discussion']->created_at) }}</small>
                                                <p class="no-margin font-italic"> {{ _trans('project.Posted by') }}
                                                    {{ $data['discussion']->user->name }}</p>
                                                <p>{{ _trans('project.Total Comments') }}:
                                                    {{ $data['discussion']->comments->count() }}</p>

                                                <hr>
                                                <div id="discussion-comments" class="tc-content jquery-comments">
                                                    <div class="card-body">
                                                        <div class="tab-pane">
                                                            @if ($data['discussion']->comments->count() > 0)
                                                                @foreach ($data['discussion']->comments as $comment)
                                                                    @if (is_null($comment->comment_id))
                                                                        <div class="post">
                                                                            <div class="user-block">
                                                                                <img class="img-circle img-bordered-sm"
                                                                                    src="{{ uploaded_asset($comment->user->avatar_id) }}"
                                                                                    alt="user image">
                                                                                <span class="username">
                                                                                    <a
                                                                                        href="#">{{ $comment->user->name }}</a>

                                                                                </span>
                                                                                <span class="description">
                                                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans() }}
                                                                                </span>
                                                                            </div>

                                                                            <p>
                                                                                <?= $comment->description ?>
                                                                            </p>
                                                                            <p>
                                                                                <a href="javascript:;"
                                                                                    class="mr-2 float-right"
                                                                                    onclick="showComments({{ $comment->id }})">
                                                                                    {{ $comment->childComments->count() }}
                                                                                    {{ _trans('common.Answers') }}
                                                                                </a>
                                                                            </p>
                                                                        </div>

                                                                        @if (@$comment->childComments)
                                                                            @foreach ($comment->childComments as $childComment)
                                                                                <div
                                                                                    class="post ml-5 dis-{{ $comment->id }} c-none clearfix">
                                                                                    <div class="user-block">
                                                                                        <img class="img-circle img-bordered-sm"
                                                                                            src="{{ uploaded_asset($childComment->user->avatar_id) }}"
                                                                                            alt="user image">
                                                                                        <span class="username">
                                                                                            <a
                                                                                                href="#">{{ $childComment->user->name }}</a>

                                                                                        </span>
                                                                                        <span class="description">
                                                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $childComment->created_at)->diffForHumans() }}
                                                                                        </span>
                                                                                    </div>

                                                                                    <p>
                                                                                        <?= $childComment->description ?>
                                                                                    </p>
                                                                                </div>
                                                                            @endforeach
                                                                            @if (hasPermission('project_discussion_comment'))
                                                                                <div
                                                                                    class="dis-{{ $comment->id }} c-none ml-5">
                                                                                    <div class="form-group">
                                                                                        <textarea id="comment-{{ $comment->id }}" class="form-control summernote" row="5" col="5"> </textarea>

                                                                                    </div>
                                                                                    <div
                                                                                        class="error-message-{{ $comment->id }}">
                                                                                    </div>
                                                                                    <div class="form-group float-right">
                                                                                        <button class="btn btn-primary"
                                                                                            onclick="commentReply( {{ $comment->id }}, `{{ route('project.discussion.comment', 'project_id=' . $data['view']->id) . '&discussion_id=' . $data['discussion']->id }}`)">{{ _trans('common.Send') }}</button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach

                                                            @endif

                                                        </div>


                                                    </div>
                                                    @if (hasPermission('project_discussion_comment'))
                                                        <input type="hidden" id="error_message_comment"
                                                            value="{{ _trans('message.Please enter a comment') }}">
                                                        <div class="form-group">
                                                            <textarea id="comment-" class="form-control summernote" row="5" col="5"> </textarea>
                                                        </div>
                                                        <div class="error-message-"></div>
                                                        <div class="form-group float-right">
                                                            <button class="btn btn-primary"
                                                                onclick="commentReply(null, `{{ route('project.discussion.comment', 'project_id=' . $data['view']->id) . '&discussion_id=' . $data['discussion']->id }}`)">{{ _trans('common.Send') }}</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                @endif
                                @if (url()->current() === route('project.view', [$data['view']->id, 'notes']) && hasPermission('project_notes_list'))
                                    <div
                                        class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                        <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                        <div class="d-flex align-items-center flex-wrap">
                                            @if (hasPermission('project_notes_create'))
                                                <div class="form-group mr-2 mb-2">
                                                    <a onclick="viewModal(`{{ route('project.note.create', 'project_id=' . $data['view']->id) }}`)"
                                                        href="javascript:;" class="btn btn-primary "> <i
                                                            class="fa fa-plus-square pr-2"></i>
                                                        {{ _trans('common.Create') }}</a>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row d-flex align-items-start mb-5">
                                        @foreach ($data['notes'] as $item)
                                            <div class="col-md-3">
                                                <div class="sticky-note">
                                                    @if (hasPermission('project_notes_delete'))
                                                        <span>
                                                            <small class="float-right text-danger cursor-pointer"
                                                                onclick="__globalDelete({{ $item->id }},`admin/project/note/delete/`)">
                                                                <i class="fas fa-times"></i>
                                                            </small>
                                                        </span>
                                                    @endif

                                                    @if (hasPermission('project_notes_edit'))
                                                        <span
                                                            onclick="viewModal(`{{ route('project.note.edit', 'project_id=' . $data['view']->id) . '&note_id=' . $item->id }}`)">
                                                            {!! \Str::limit(strip_tags($item->description), 100) !!}
                                                        </span>
                                                    @else
                                                        {!! \Str::limit(strip_tags($item->description), 100) !!}
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                @endif
                                @if (url()->current() === route('project.view', [$data['view']->id, 'tasks']) && hasPermission('task_list'))
                                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                        <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                        <div class="d-flex align-items-center flex-wrap">
                                            @if (hasPermission('task_create'))
                                                <div class="form-group mr-2 mb-2">
                                                    <a href="{{ route('task.create', 'project_id=' . $data['view']->id) }}" target="_blank" class="btn btn-primary "> <i
                                                            class="fa fa-plus-square pr-2"></i>
                                                        {{ _trans('common.Create') }}</a>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row dataTable-btButtons">
                                        <div class="col-lg-12">
                                            @include('backend.partials.tablePartial')
                                        </div>
                                    </div>

                                @endif

                                @if (url()->current() === route('project.view', [$data['view']->id, 'activity']) && hasPermission('project_activity_view'))
                                    <div class="row ">
                                        <div class="col-md-12">
                                            @foreach ($data['activity'] as $item)
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                            src="{{ uploaded_asset($item->avatar_id) }}"
                                                            alt="user image">
                                                        <span class="username">
                                                            <b>{{ $item->username }}</b>
                                                        </span>
                                                        <span
                                                            class="description">{{ showTimeFromTimeStamp($item->created_at) }}</span>
                                                    </div>

                                                    <p>
                                                        {{ @$item->description }}
                                                    </p>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>

                                @endif
                                @if (url()->current() === route('project.view', [$data['view']->id, 'members']) && hasPermission('project_member_view'))
                                    <div class="row ">
                                        <div class="col-md-12">
                                            @if (@$data['members'])
                                                @foreach ($data['members'][0]->members as $item)
                                                    <div class="post">
                                                        <div class="user-block">
                                                            <img class="img-circle img-bordered-sm"
                                                                src="{{ uploaded_asset($item->user->avatar_id) }}"
                                                                alt="user image">
                                                            <span class="username">
                                                                <b>{{ $item->user->name }}</b>
                                                                {{ _trans('project.Added By') }} {{ $item->_by->name }}
                                                                @if (hasPermission('project_member_delete'))
                                                                    <a href="javascript:;" class="float-right btn-tool" onclick="__globalDelete(`{{$item->id}}?project_id={{ $data['view']->id }}`,`admin/project/member-delete/`)">
                                                                        <i class="fas fa-times"></i></a>
                                                                @endif
                                                            </span>
                                                            <span
                                                                class="description">{{ showTimeFromTimeStamp($item->created_at) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif


                                        </div>
                                    </div>

                                @endif
                                @if (url()->current() === route('project.view', [$data['view']->id, 'files']) && hasPermission('project_file_list'))

                                    @if ($data['table'])
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                            <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                            <div class="d-flex align-items-center flex-wrap">
                                                @if (hasPermission('project_files_create'))
                                                    <div class="form-group mr-2 mb-2">
                                                        <a onclick="viewModal(`{{ route('project.file.create', 'project_id=' . $data['view']->id) }}`)"
                                                            href="javascript:;" class="btn btn-primary "> <i
                                                                class="fa fa-plus-square pr-2"></i>
                                                            {{ _trans('common.Create') }}</a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row dataTable-btButtons">
                                            <div class="col-lg-12">
                                                @include('backend.partials.tablePartial')
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                            <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                        </div>

                                        <div class="panel_s">
                                            <div class="panel-body font-size-13">
                                                <h3 class="bold no-margin font-size-14">
                                                    {{ @$data['file']->subject }}
                                                </h3>
                                                <hr>
                                                <div class="mb-2">
                                                    <img class="img-responsive"
                                                        src="{{ uploaded_asset($data['file']->attachment) }}"
                                                        alt="">
                                                </div>

                                                <div class="mt-4 mb-4 display-block">
                                                    <a href="{{ route('project.file.download', 'project_id=' . $data['view']->id) . '&file_id=' . $data['file']->id }}"
                                                        class="link-black text-sm"><i class="fas fa-link mr-1"></i>
                                                        {{ @$data['file']->subject }} </a>
                                                </div>

                                                <small class="font-size-13">{{ _trans('project.Posted on') }}
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['file']->created_at) }}</small>
                                                <p class="no-margin font-italic"> {{ _trans('project.Posted by') }}
                                                    {{ $data['file']->user->name }}</p>
                                                <p>{{ _trans('project.Total Comments') }}:
                                                    {{ $data['file']->comments->count() }}</p>

                                                <hr>
                                                <div id="discussion-comments" class="tc-content jquery-comments">
                                                    <div class="card-body">
                                                        <div class="tab-pane">
                                                            @if ($data['file']->comments->count() > 0)
                                                                @foreach ($data['file']->comments as $comment)
                                                                    @if (is_null($comment->comment_id))
                                                                        <div class="post">
                                                                            <div class="user-block">
                                                                                <img class="img-circle img-bordered-sm"
                                                                                    src="{{ uploaded_asset($comment->user->avatar_id) }}"
                                                                                    alt="user image">
                                                                                <span class="username">
                                                                                    <a
                                                                                        href="#">{{ $comment->user->name }}</a>

                                                                                </span>
                                                                                <span class="description">
                                                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans() }}
                                                                                </span>
                                                                            </div>

                                                                            <p>
                                                                                <?= $comment->description ?>
                                                                            </p>
                                                                            <p>
                                                                                <a href="javascript:;"
                                                                                    class="mr-2 float-right"
                                                                                    onclick="showComments({{ $comment->id }})">
                                                                                    {{ $comment->childComments->count() }}
                                                                                    {{ _trans('common.Answers') }}
                                                                                </a>
                                                                            </p>
                                                                        </div>

                                                                        @if (@$comment->childComments)
                                                                            @foreach ($comment->childComments as $childComment)
                                                                                <div
                                                                                    class="post ml-5 dis-{{ $comment->id }} c-none clearfix">
                                                                                    <div class="user-block">
                                                                                        <img class="img-circle img-bordered-sm"
                                                                                            src="{{ uploaded_asset($childComment->user->avatar_id) }}"
                                                                                            alt="user image">
                                                                                        <span class="username">
                                                                                            <a
                                                                                                href="#">{{ $childComment->user->name }}</a>
                                                                                        </span>
                                                                                        <span class="description">
                                                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $childComment->created_at)->diffForHumans() }}
                                                                                        </span>
                                                                                    </div>

                                                                                    <p>
                                                                                        <?= $childComment->description ?>
                                                                                    </p>
                                                                                </div>
                                                                            @endforeach
                                                                            @if (hasPermission('project_file_comment'))
                                                                                <div
                                                                                    class="dis-{{ $comment->id }} c-none ml-5">
                                                                                    <div class="form-group">
                                                                                        <textarea id="comment-{{ $comment->id }}" class="form-control summernote" row="5" col="5"> </textarea>

                                                                                    </div>
                                                                                    <div
                                                                                        class="error-message-{{ $comment->id }}">
                                                                                    </div>
                                                                                    <div class="form-group float-right">
                                                                                        <button class="btn btn-primary"
                                                                                            onclick="commentReply( {{ $comment->id }}, `{{ route('project.file.comment', 'project_id=' . $data['view']->id) . '&file_id=' . $data['file']->id }}` )">{{ _trans('common.Send') }}</button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach

                                                            @endif

                                                        </div>


                                                    </div>
                                                    @if (hasPermission('project_file_comment'))
                                                        <input type="hidden" id="error_message_comment"
                                                            value="{{ _trans('message.Please enter a comment') }}">
                                                        <div class="form-group">
                                                            <textarea id="comment-" class="form-control summernote" row="5" col="5"> </textarea>
                                                        </div>
                                                        <div class="error-message-"></div>
                                                        <div class="form-group float-right">
                                                            <button class="btn btn-primary"
                                                                onclick="commentReply(null, `{{ route('project.file.comment', 'project_id=' . $data['view']->id) . '&file_id=' . $data['file']->id }}` )">{{ _trans('common.Send') }}</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="text" hidden id="{{ @$data['url_id'] }}" value="{{ @$data['datatable_url'] }}">
@endsection
@section('script')
    <script src="{{ asset('public/backend/js/pages/__project.js') }}"></script>
    <script src="{{ asset('public/backend/js/pages/__task.js') }}"></script>
    @if (@$data['is_datatable'])
        @include('backend.partials.datatable')
    @endif
@endsection
