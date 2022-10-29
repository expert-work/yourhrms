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
                            @if (hasPermission('task_list'))
                                <li class="breadcrumb-item"><a
                                        href="{{ route('task.index') }}">{{ _trans('common.List') }}</a>
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
                            @include('backend.task.tab')
                        </div>
                        <div class="card">

                            <div class="card-body">
                                @if (url()->current() === route('task.view', [$data['view']->id, 'details']) && hasPermission('task_view'))
                                
                                    <div class="panel_s">
                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="col-md-8 border-right project-overview-left">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                                                <h6 class="project-info bold font-size-14">
                                                                    {{ _trans('common.Details') }}</h6>
                                                                <div class="d-flex align-items-center flex-wrap">
                                                                    @if (hasPermission('task_complete') && $data['view']->status_id != 27)
                                                                        <div class="form-group mr-2 mb-2">
                                                                            <a onclick="GlobalApprove(`{{ route('task.complete', '&task_id=' . $data['view']->id) }}`, `{{ _trans('task.Task Complete') }}` )"
                                                                                href="javascript:;"
                                                                                class="btn btn-primary "> <i
                                                                                    class="fa fa-check"></i></a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table project-overview-table">
                                                                <tbody>
                                                                    <div class="project-overview-id">
                                                                        <p> {{ @$data['view']->name }} </p>
                                                                    </div>
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
                                                <div class="col-md-4 project-overview-right">
                                                    <table class="table project-overview-table">
                                                        <tbody>
                                                            <tr class="project-overview-status">
                                                                <td class="bold">{{ _trans('common.Status') }}
                                                                </td>
                                                                <td>
                                                                    <?= '<small class="badge badge-' . @$data['view']->status->class . '">' . @$data['view']->status->name . '</small>' ?>
                                                                </td>
                                                            </tr>
                                                            <tr class="project-overview-status">
                                                                <td class="bold">{{ _trans('common.Priority') }}
                                                                </td>
                                                                <td>
                                                                    <?= '<small class="badge badge-' . @$data['view']->priorityStatus->class . '">' . @$data['view']->priorityStatus->name . '</small>' ?>
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
                                                                <td class="bold">{{ _trans('common.End Date') }}
                                                                </td>
                                                                <td>{{ showDate($data['view']->end_date) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    {{ _trans('task.Task Progress') }}
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
                                        </div>
                                    </div>
                                @endif

                                @if (url()->current() === route('task.view', [$data['view']->id, 'discussions']) && hasPermission('task_discussion_list'))
                                    @if ($data['table'])
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                            <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                            <div class="d-flex align-items-center flex-wrap">
                                                @if (hasPermission('task_discussion_create'))
                                                    <div class="form-group mr-2 mb-2">
                                                        <a onclick="viewModal(`{{ route('task.discussion.create', 'task_id=' . $data['view']->id) }}`)"
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
                                                                            @if (hasPermission('task_discussion_comment'))
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
                                                                                            onclick="commentReply( {{ $comment->id }}, `{{ route('task.discussion.comment', 'task_id=' . $data['view']->id) . '&discussion_id=' . $data['discussion']->id }}`)">{{ _trans('common.Send') }}</button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach

                                                            @endif

                                                        </div>


                                                    </div>
                                                    @if (hasPermission('task_discussion_comment'))
                                                        <input type="hidden" id="error_message_comment"
                                                            value="{{ _trans('message.Please enter a comment') }}">
                                                        <div class="form-group">
                                                            <textarea id="comment-" class="form-control summernote" row="5" col="5"> </textarea>
                                                        </div>
                                                        <div class="error-message-"></div>
                                                        <div class="form-group float-right">
                                                            <button class="btn btn-primary"
                                                                onclick="commentReply(null, `{{ route('task.discussion.comment', 'task_id=' . $data['view']->id) . '&discussion_id=' . $data['discussion']->id }}`)">{{ _trans('common.Send') }}</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                @endif
                                @if (url()->current() === route('task.view', [$data['view']->id, 'notes']) && hasPermission('task_notes_list'))
                                    <div
                                        class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                        <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                        <div class="d-flex align-items-center flex-wrap">
                                            @if (hasPermission('task_notes_create'))
                                                <div class="form-group mr-2 mb-2">
                                                    <a onclick="viewModal(`{{ route('task.note.create', 'task_id=' . $data['view']->id) }}`)"
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
                                                    @if (hasPermission('task_notes_delete'))
                                                        <span>
                                                            <small class="float-right text-danger cursor-pointer"
                                                                onclick="__globalDelete({{ $item->id }},`admin/task/note/delete/`)">
                                                                <i class="fas fa-times"></i>
                                                            </small>
                                                        </span>
                                                    @endif

                                                    @if (hasPermission('task_notes_edit'))
                                                        <span
                                                            onclick="viewModal(`{{ route('task.note.edit', 'task_id=' . $data['view']->id) . '&note_id=' . $item->id }}`)">
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

                                @if (url()->current() === route('task.view', [$data['view']->id, 'activity']) && hasPermission('task_activity_view'))
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
                                @if (url()->current() === route('task.view', [$data['view']->id, 'members']) && hasPermission('task_assign_view'))
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
                                                                {{ _trans('project.Added By') }} {{ @$item->_by->name }}
                                                                @if (hasPermission('task_assign_delete'))
                                                                    <a href="javascript:;" class="float-right btn-tool" onclick="__globalDelete(`{{$item->id}}?task_id={{ $data['view']->id }}`,`admin/task/member-delete/`)">
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
                                @if (url()->current() === route('task.view', [$data['view']->id, 'files']) && hasPermission('task_file_list'))

                                    @if ($data['table'])
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 flex-wrap parent-select2-width">
                                            <h5 class="fm-poppins m-0 text-dark font-size-14">{{ @$data['slug'] }}</h5>
                                            <div class="d-flex align-items-center flex-wrap">
                                                @if (hasPermission('task_files_create'))
                                                    <div class="form-group mr-2 mb-2">
                                                        <a onclick="viewModal(`{{ route('task.file.create', 'task_id=' . $data['view']->id) }}`)"
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
                                                    <a href="{{ route('task.file.download', 'task_id=' . $data['view']->id) . '&file_id=' . $data['file']->id }}"
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
                                                                            @if (hasPermission('task_file_comment'))
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
                                                                                            onclick="commentReply( {{ $comment->id }}, `{{ route('task.file.comment', 'task_id=' . $data['view']->id) . '&file_id=' . $data['file']->id }}` )">{{ _trans('common.Send') }}</button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach

                                                            @endif

                                                        </div>


                                                    </div>
                                                    @if (hasPermission('task_file_comment'))
                                                        <input type="hidden" id="error_message_comment"
                                                            value="{{ _trans('message.Please enter a comment') }}">
                                                        <div class="form-group">
                                                            <textarea id="comment-" class="form-control summernote" row="5" col="5"> </textarea>
                                                        </div>
                                                        <div class="error-message-"></div>
                                                        <div class="form-group float-right">
                                                            <button class="btn btn-primary"
                                                                onclick="commentReply(null, `{{ route('task.file.comment', 'task_id=' . $data['view']->id) . '&file_id=' . $data['file']->id }}` )">{{ _trans('common.Send') }}</button>
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
    <input type="text" hidden id="{{ @$data['url_id'] }}" value="{{ @$data['table_url'] }}">
@endsection
@section('script')
    <script src="{{ asset('public/backend/js/pages/__project.js') }}"></script>
    <script src="{{ asset('public/backend/js/pages/__task.js') }}"></script>
@endsection
