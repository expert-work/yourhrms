<?php

namespace App\Services\Performance;

use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Performance\GoalType;
use App\Models\Performance\Appraisal;
use App\Models\Performance\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Models\Performance\CompetenceType;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class GoalTypeService extends BaseService
{
    use RelationshipTrait, DateHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(GoalType $goalType)
    {
        $this->model = $goalType;
    }
    
    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('task.Name'),
            _trans('common.Status'),
            _trans('common.Action')

        ];
    }


    function table($request)
    {
        $files =  $this->model->where(['company_id' => auth()->user()->company_id])->paginate($request->limit ?? 10);
        return [
            'data' => $files->map(function ($data) {
                $action_button = '';
                if (hasPermission('performance_goal_type_edit')) {
                    $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('performance.goal_type.edit', $data->id) . '`)', 'modal');
                }
                if (hasPermission('performance_goal_type_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/performance/settings/goal-type/delete/`)', 'delete');
                }
                $button = '<div class="flex-nowrap">
                                <div class="dropdown">
                                    <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn ll"  role="button" data-toggle="dropdown" aria-expanded="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                                </div>
                            </div>';

                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
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
                'total' => $files->total(),
                'count' => $files->count(),
                'per_page' => $files->perPage(),
                'current_page' => $files->currentPage(),
                'total_pages' => $files->lastPage()
            ],
        ];
    }

    function store($request)
    {
        DB::beginTransaction();
        try {
            $goal_type                           = new $this->model;
            $goal_type->name                     = $request->name;
            $goal_type->status_id                = $request->status;
            $goal_type->company_id               = auth()->user()->company_id;
            $goal_type->created_by               = auth()->id();
            $goal_type->updated_by               = auth()->id();
            $goal_type->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Goal type created successfully.'), $goal_type);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $goal_type = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
            if (!$goal_type) {
                return $this->responseWithError(_trans('message.Goal Type not found'), 'id', 404);
            }
            $goal_type->name                     = $request->name;
            $goal_type->status_id                = $request->status;
            $goal_type->updated_by               = auth()->id();
            $goal_type->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Goal type created successfully.'), $goal_type);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $goal_type = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$goal_type) {
            return $this->responseWithError(_trans('message.Goal type not found'), 'id', 404);
        }
        try {
            $goal_type->goals()->delete();
            $goal_type->delete();
            return $this->responseWithSuccess(_trans('message.Goal type Delete successfully.'), $goal_type);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
