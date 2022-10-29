<?php

namespace App\Services\Management;

use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Management\Discussion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use Illuminate\Support\Facades\Log;

class DiscussionService extends BaseService
{
    use RelationshipTrait, DateHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(Discussion $discussion)
    {
        $this->model = $discussion;
    }

    //discussions datatable 

    function discussionDatatable($request, $id){
        $content =  $this->model->query()->with('comments')->where([
            'project_id' => $id,
            'company_id' => auth()->user()->company_id,
        ]);
        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';


                if (hasPermission('discussion_view')) {
                    $action_button .= '<a href="' . route('project.view', [$data->project_id, 'discussions', 'discussion_id='.$data->id]) . '" class="dropdown-item"> ' . _trans('common.View') . '</a>';
                }
                if (hasPermission('discussion_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/project/discussion/delete/`)', 'delete');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('visible', function ($data) {
                return '<small class="badge badge-' . @$data->visitCustomer->class . '">' . @$data->visitCustomer->name . '</small>';
            })
            ->addColumn('comments', function ($data) {
                return $data->comments->count();
            })
            ->addColumn('last_activity', function ($data) {
                return showDate($data->last_activity);
            })
            ->addColumn('time', function ($data) {
                return showDate($data->created_at);
            })
            ->rawColumns(array('visible','comments', 'last_activity', 'time', 'action'))
            ->make(true);
    
    }

    // store the
    public function store($request)
    {
        
        $validator = Validator::make(\request()->all(), [
            'description' => 'required',
            'subject' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $project = DB::table('projects')->where('id', $request->project_id)->first();
            if (!$project) {
                return $this->responseWithError(__('Project not found'), [], 400);
            }
            $data = [
                'company_id' => auth()->user()->company_id,
                'project_id' => $request->project_id,
                'subject' => $request->subject,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'show_to_customer' => @$request->show_to_customer == 1  ? 33 : 22,
                'last_activity' => date('Y-m-d H:i:s'),
            ];
            $discussion = $this->model->create($data);            
            \App\Models\Management\ProjectActivity::CreateActivityLog(auth()->user()->company_id, $project->id, auth()->id(), 'Created Discussion')->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Discussion created successfully.'), $discussion);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
    // comment store the
    public function commentStore($request)
    {
        // Log::info($request->all());
        
        $validator = Validator::make(\request()->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $discussion = $this->model->where([
                'id' => $request->discussion_id,
                'company_id' => auth()->user()->company_id,
            ])->first();
            if (!$discussion) {
                return $this->responseWithError(__('Discussion not found'), [], 400);
            }
            $comment = new \App\Models\Management\DiscussionComment;
            $comment->company_id = auth()->user()->company_id;
            $comment->discussion_id = $request->discussion_id;
            $comment->comment_id = $request->comment_id ?? null;
            $comment->description = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->save();
            \App\Models\Management\ProjectActivity::CreateActivityLog(auth()->user()->company_id, $discussion->project_id, auth()->id(), 'Created Discussion Comments')->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Comment created successfully.'), $comment);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $discussion = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$discussion) {
            return $this->responseWithError(_trans('Discussion not found'), 'id', 404);
        }
        try {
            $discussion->comments()->delete();
            $discussion->delete();            
            \App\Models\Management\ProjectActivity::CreateActivityLog(auth()->user()->company_id, $discussion->project_id, auth()->id(), 'Deleted Discussion')->save();
            return $this->responseWithSuccess(_trans('message.Discussion Delete successfully.'), $discussion);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
}