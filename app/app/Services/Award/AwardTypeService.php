<?php

namespace App\Services\Award;

use App\Models\Award\AwardType;
use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use Illuminate\Support\Facades\Log;

class AwardTypeService extends BaseService
{
    use RelationshipTrait, DateHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(AwardType $awardType)
    {
        $this->model = $awardType;
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
                if (hasPermission('award_type_edit')) {
                    $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('award_type.edit', $data->id) . '`)', 'modal');
                }
                if (hasPermission('award_type_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/award/type/delete/`)', 'delete');
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
            $award_type                           = new $this->model;
            $award_type->name                     = $request->name;
            $award_type->status_id                = $request->status;
            $award_type->company_id               = auth()->user()->company_id;
            $award_type->created_by               = auth()->id();
            $award_type->updated_by               = auth()->id();
            $award_type->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Award type created successfully.'), $award_type);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $award_type = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
            if (!$award_type) {
                return $this->responseWithError(_trans('message.Award Type not found'), 'id', 404);
            }
            $award_type->name                     = $request->name;
            $award_type->status_id                = $request->status;
            $award_type->updated_by               = auth()->id();
            $award_type->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Award type created successfully.'), $award_type);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $award_type = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$award_type) {
            return $this->responseWithError(_trans('message.Award type not found'), 'id', 404);
        }
        try {
            $award_type->awards()->delete();
            $award_type->delete();
            return $this->responseWithSuccess(_trans('message.Award type Delete successfully.'), $award_type);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
