<?php

namespace App\Services\Performance;

use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Performance\Competence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class CompetenceService extends BaseService
{
    use RelationshipTrait, DateHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(Competence $competence)
    {
        $this->model = $competence;
    }
    function fields()
    {
        return [
            _trans('common.Id'),
            _trans('common.Name'),
            _trans('performance.Competence Type'),
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
                if (hasPermission('performance_competence_edit')) {
                    $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('performance.competence.edit', $data->id) . '`)', 'modal');
                }
                if (hasPermission('performance_competence_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/performance/settings/competence/delete/`)', 'delete');
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
                    'type' => $data->competenceType->name,
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
        // dd($request->all());
        $validator = Validator::make(\request()->all(), [
            'name' => 'required|max:191',
            'competence_type_id' => 'required|exists:competence_types,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $competence                           = new $this->model;
            $competence->name                     = $request->name;
            $competence->competence_type_id       = $request->competence_type_id;
            $competence->status_id                = $request->status;
            $competence->company_id               = auth()->user()->company_id;
            $competence->created_by               = auth()->id();
            $competence->updated_by               = auth()->id();
            $competence->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Appraisal created successfully.'), $competence);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function update($request, $id)
    {
        $validator = Validator::make(\request()->all(), [
            'name' => 'required|max:191',
            'competence_type_id' => 'required|exists:competence_types,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $competence = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
            if (!$competence) {
                return $this->responseWithError(_trans('message.Competence not found'), 'id', 404);
            }
            $competence->name                     = $request->name;
            $competence->competence_type_id       = $request->competence_type_id;
            $competence->status_id                = $request->status;
            $competence->updated_by               = auth()->id();
            $competence->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Competence Updated successfully.'), $competence);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $competence = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$competence) {
            return $this->responseWithError(_trans('message.Competence not found'), 'id', 404);
        }
        try {
            $competence->delete();
            return $this->responseWithSuccess(_trans('message.Competence Delete successfully.'), $competence);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
