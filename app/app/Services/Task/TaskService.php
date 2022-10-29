<?php

namespace App\Services\Task;

use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\TaskManagement\Task;
use App\Services\Task\TaskFileService;
use App\Services\Task\TaskNoteService;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Services\Task\TaskDiscussionService;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use Illuminate\Support\Facades\Log;

class TaskService extends BaseService
{
    use RelationshipTrait, DateHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    protected $discussionService;
    protected $noteService;
    protected $fileService;
    public function __construct(Task $task, TaskDiscussionService $discussionService, TaskNoteService $noteService, TaskFileService $fileService)
    {
        $this->model = $task;
        $this->discussionService = $discussionService;
        $this->noteService = $noteService;
        $this->fileService = $fileService;
    }

    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('task.Name'),
            _trans('common.Status'),
            _trans('common.Start Date'),
            _trans('project.End Date'),
            _trans('task.Assigned To'),
            _trans('project.Priority'),
            _trans('common.Action')

        ];
    }


    function userDatatable($request,$user_id)
    {
        $where = [];
        if($request->project_id){
            $where = ['type' => 1, 'project_id' => $request->project_id];
        }
        $content =  $this->model->with('members','status')->where(['company_id' => auth()->user()->company_id])->where($where);
        
        $content = $content->whereHas('members', function (Builder $query) use($user_id) {
            $query->where('user_id', $user_id);
        });
        $content = $content->paginate($request->limit ?? 10);

        return $this->generateDatatable($content);
        
    }
    function table($request)
    {
        $where = [];
        if($request->project_id){
            $where = ['type' => 1, 'project_id' => $request->project_id];
        }
        $content =  $this->model->with('members','status')->where(['company_id' => auth()->user()->company_id])->where($where);
        if (!is_Admin()) {
            $content = $content->whereHas('members', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        }
        $content = $content->paginate($request->limit ?? 10);

        return $this->generateDatatable($content);
        
    }
    function generateDatatable($content)
    {
        return [
            'data' => $content->map(function ($data) {
                $action_button = '';
                if (hasPermission('task_view')) {
                    $action_button .= '<a href="' . route('task.view', [$data->id, 'details']) . '" class="dropdown-item"> ' . _trans('common.View') . '</a>';
                }
                if (hasPermission('task_edit')) {
                    $action_button .= '<a href="' . route('task.edit', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('task_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/task/delete/`)', 'delete');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn ll"  role="button" data-toggle="dropdown" aria-expanded="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';

                $membars = '';
                foreach ($data->members as $member) {
                    if (hasPermission('profile_view')) {
                        $url = route('user.profile', [$member->user->id, 'official']);
                    } else {
                        $url = '#';
                    }
                    $membars .= '<a target="_blank" href="' . $url  . '"><img data-toggle="tooltip" data-placement="top" title="' . $member->user->name . '" src="' . uploaded_asset($member->user->avatar_id) . '" class="staff-profile-image-small" ></a>';
                }

                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'date' => showDate($data->created_at),
                    'start_date' => showDate($data->start_date),
                    'end_date' => showDate($data->end_date),
                    'priority' => '<small class="badge badge-' . @$data->priorityStatus->class . '">' . @$data->priorityStatus->name . '</small>',
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'assignee' => $membars,
                    'action'   => $button
                ];
            }),
            'links' => [
                "first" => \request()->url() . "?page=1",
                "last" => \request()->url() . "?page=1",
                "prev" => null,
                "next" => null
            ],
            'pagination' => [
                'total' => $content->total(),
                'count' => $content->count(),
                'per_page' => $content->perPage(),
                'current_page' => $content->currentPage(),
                'total_pages' => $content->lastPage()
            ],
        ];
    }

    function store($request)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            $task                           = new $this->model;
            $task->name                     = $request->name;
            $task->date                     = date('Y-m-d');
            $task->progress                 = $request->progress;
            $task->status_id                = $request->status;
            $task->priority                 = $request->priority;
            $task->description              = $request->content;
            $task->start_date               = $request->start_date;
            $task->end_date                 = $request->end_date;
            $task->notify_all_users         = $request->notify_all_users;
            $task->notify_all_users_email   = $request->notify_all_users_email;
            $task->company_id               = auth()->user()->company_id;
            $task->created_by               = auth()->id();
            if (@$request->project_id) {
                $task->project_id           = $request->project_id;
                $task->type                 = 1;
                \App\Models\Management\ProjectActivity::CreateActivityLog(auth()->user()->company_id, $request->project_id, auth()->id(), 'Created the Task')->save();

            }
            $task->save();

            //team members assign to task
            if (@$request->user_ids) {
                foreach ($request->user_ids as $user_id) {
                    DB::table('task_members')->insert([
                        'task_id' => $task->id,
                        'company_id' => auth()->user()->company_id,
                        'user_id' => $user_id,
                        'added_by' => auth()->id(),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            \App\Models\TaskManagement\TaskActivity::CreateActivityLog(auth()->user()->company_id, $task->id, auth()->id(), 'Created the Task')->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Task created successfully.'), $task);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function update($request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $params                = [
                'id' => $id,
                'company_id' => auth()->user()->company_id,
            ];
            $task      = $this->model->where($params)->with('members')->first();
            if (!$task) {
                return $this->responseWithError(_trans('Task not found'), 'id', 404);
            }

            $task->name                     = $request->name;
            $task->progress                 = $request->progress;
            $task->status_id                = $request->status;
            $task->priority                 = $request->priority;
            $task->description              = $request->content;
            $task->start_date               = $request->start_date;
            $task->end_date                 = $request->end_date;
            $task->notify_all_users         = $request->notify_all_users;
            $task->notify_all_users_email   = $request->notify_all_users_email;
            $task->goal_id                  = @$request->goal_id ;

            if (@$task->project_id) {
                \App\Models\Management\ProjectActivity::CreateActivityLog(auth()->user()->company_id, $task->project_id, auth()->id(), 'Updated the Task')->save();
            }
            $task->save();

            //team members assign to project
            if (@$request->new_members && $request->new_members[0] != false) {
                foreach ($request->new_members as $user_id) {
                    DB::table('project_membars')->insert([
                        'task_id' => $task->id,
                        'company_id' => auth()->user()->company_id,
                        'added_by' => auth()->id(),
                        'user_id' => $user_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            if (@$request->remove_members && $request->remove_members[0] != false) {
                $task->members()->whereIn('user_id', @$request->remove_members)->delete();
            }
            \App\Models\TaskManagement\TaskActivity::CreateActivityLog(auth()->user()->company_id, $task->id, auth()->id(), 'Updated the task')->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Task Updated successfully.'), $task);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $task = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$task) {
            return $this->responseWithError(_trans('message.Task not found'), 'id', 404);
        }
        try {
            if (@$task->project_id) {
                \App\Models\Management\ProjectActivity::CreateActivityLog(auth()->user()->company_id, $task->project_id, auth()->id(), 'Updated the Task')->save();

            }
            $task->files()->delete();
            $task->notes()->delete();
            $task->discussions()->delete();
            $task->members()->delete();
            $task->delete();
            return $this->responseWithSuccess(_trans('message.Task Delete successfully.'), $task);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    //member_delete
    function member_delete($request, $id)
    {
        try {
            $task = $this->model->with('members')->where(['id' => $request->task_id, 'company_id' => auth()->user()->company_id])->first();
            if (!$task) {
                return $this->responseWithError(_trans('Task not found'), 'id', 404);
            }
            $membar = $task->members->find($id);
            if (!$membar) {
                return $this->responseWithError(_trans('Member not found'), 'id', 404);
            }
            \App\Models\TaskManagement\TaskActivity::CreateActivityLog(auth()->user()->company_id, $task->id, auth()->id(), 'Deleted the member')->save();
            $membar->delete();
            return $this->responseWithSuccess(_trans('message.Member Delete successfully.'), $task);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    // discussions fields

    function discussionsField()
    {
        return [
            _trans('common.ID'),
            _trans('common.Subject'),
            _trans('project.Last Activity'),
            _trans('common.Comments'),
            // _trans('project.Visible To Customer'),
            _trans('common.Date Created'),
            _trans('common.Action'),
        ];
    }
    // files fields

    function filesField()
    {
        return [
            _trans('common.ID'),
            _trans('common.Subject'),
            _trans('project.Last Activity'),
            _trans('common.Comments'),
            _trans('common.Date Created'),
            _trans('common.Action'),
        ];
    }





    function view($id, $slug, $request)
    {

        $task = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$task) {
            return $this->responseWithError(_trans('Task not found'), 'id', 404);
        }
        try {
            $data['view'] = $task;
            if ($slug == 'tasks') {
                $data['tasks'] = $task;
            } elseif ($slug == 'files') {

                $data['slug']          = _trans('project.Files');
                if (@$request->file_id) {
                    $data['file'] = $this->fileService->where([
                        'id'         => $request->file_id,
                        'company_id' => auth()->user()->company_id,
                    ])->with('comments')->first();
                    if (blank($data['file'])) {
                        return $this->responseWithError(_trans('message.File not found'), 'id', 404);
                    }
                    $data['table']   = false;
                } else {

                    $data['table_url']         = route('task.file.table', $task->id);
                    $data['url_id']        = 'file_table_url';
                    $data['fields']        = $this->filesField();
                    $data['class']     = 'file_table_data';
                    $data['table']         = true;
                }
            } elseif ($slug == 'members') {
                $data['members'] = $task->with('members._by')->get();
            } elseif ($slug == 'discussions') {
                $data['slug']          = _trans('project.Discussions');
                if (@$request->discussion_id) {
                    $data['discussion'] = $this->discussionService->where([
                        'id'         => $request->discussion_id,
                        'company_id' => auth()->user()->company_id,
                    ])->with('comments')->first();
                    if (blank($data['discussion'])) {
                        return $this->responseWithError(_trans('message.Discussion not found'), 'id', 404);
                    }
                    $data['table']   = false;
                } else {
                    $data['table_url']         = route('task.discussion.table', $task->id);
                    $data['url_id']        = 'discussion_table_url';
                    $data['fields']        = $this->discussionsField();
                    $data['class']         = 'discussion_table_class';
                    $data['table']         = true;
                }
            } elseif ($slug == 'notes') {
                $data['slug']          = _trans('project.Notes');
                $data['notes']         = $this->noteService->where(['task_id' => $task->id, 'company_id' => auth()->user()->company_id])->get();
            } elseif ($slug == 'activity') {
                $data['activity'] = DB::table('task_activities')
                    ->join('users', 'task_activities.user_id', '=', 'users.id')
                    ->select('users.name as username', 'users.avatar_id', 'task_activities.*')
                    ->where(['task_activities.task_id' => $task->id, 'task_activities.company_id' => auth()->user()->company_id])
                    ->orderBy('id', 'desc')
                    ->get();
            }
            return $this->responseWithSuccess('data retrieve', $data);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function status($request)
    {

        $task = $this->model->where(['id' => $request->task_id, 'company_id' => auth()->user()->company_id])->first();
        if (!$task) {
            return $this->responseWithError(_trans('message.Task not found'), 'id', 404);
        }
        try {

            $task->status_id = 27;
            $task->save();
            \App\Models\TaskManagement\TaskActivity::CreateActivityLog(auth()->user()->company_id, $task->id, auth()->id(), 'Task Completed')->save();
            return $this->responseWithSuccess(_trans('message.Task Completed successfully.'), $task);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
