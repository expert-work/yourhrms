<?php

namespace App\Services\Performance;

use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Performance\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class IndicatorService extends BaseService
{
    use RelationshipTrait, DateHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(Indicator $indicator)
    {
        $this->model = $indicator;
    }
    function fields()
    {
        return [
            _trans('common.Title'),
            _trans('common.Department'),
            _trans('common.Designation'),
            _trans('common.Shift'),
            _trans('common.Rating'),
            _trans('common.Added By'),
            _trans('common.Created At'),
            _trans('common.Action')

        ];
    }


    function table($request)
    {
        $files =  $this->model->where(['company_id' => auth()->user()->company_id])->paginate($request->limit ?? 10);
        return [
            'data' => $files->map(function ($data) {
                $action_button = '';
                if (hasPermission('performance_indicator_view')) {
                    $action_button .= actionButton(_trans('common.View'), 'mainModalOpen(`' . route('performance.indicator.view', $data->id) . '`)', 'modal');
                }
                if (hasPermission('performance_indicator_edit')) {
                    $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('performance.indicator.edit', $data->id) . '`)', 'modal');
                }
                if (hasPermission('performance_indicator_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/performance/indicator/delete/`)', 'delete');
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
                    'title' => $data->name,
                    'department' => $data->department->title,
                    'designation' => $data->designation->title,
                    'shift' => $data->shift->name,
                    'rating' => view('backend.performance.rating_show', compact('data')) . '(' . $data->rating . ')',
                    'added_by' => $data->added->name,
                    'created_at' => showDate($data->created_at),
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
            'title' => 'required|max:191',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'shift_id' => 'required|exists:shifts,id',
            'rating' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $rates = 0;
            $rates_json = [];
            $indicator                           = new $this->model;
            $indicator->name                    = $request->title;
            $indicator->department_id            = $request->department_id;
            $indicator->designation_id           = $request->designation_id;
            $indicator->shift_id                 = $request->shift_id;
            $indicator->company_id               = auth()->user()->company_id;
            $indicator->added_by                 = auth()->id();
            if ($request->has('rating')) {
               foreach ($request->get('rating') as $key => $value) {
                     $rates += $value;
                        $rates_json[] = [
                            'rating' => $value,
                            'id' => $key
                        ];
               }
            }
            $indicator->rating = $rates / count($request->get('rating'));
            $indicator->rates = $rates_json;
            $indicator->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Indicator created successfully.'), $indicator);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function update($request, $id)
    {
        // dd($request->all());
        $validator = Validator::make(\request()->all(), [
            'title' => 'required|max:191',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'shift_id' => 'required|exists:shifts,id',
            'rating' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $indicator = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
            if (!$indicator) {
                return $this->responseWithError(_trans('message.Indicator not found'), 'id', 404);
            }
            $rates = 0;
            $rates_json = [];
            $indicator->name                    = $request->title;
            $indicator->department_id            = $request->department_id;
            $indicator->designation_id           = $request->designation_id;
            $indicator->shift_id                 = $request->shift_id;
            $indicator->company_id               = auth()->user()->company_id;
            $indicator->added_by                 = auth()->id();
            if ($request->has('rating')) {
               foreach ($request->get('rating') as $key => $value) {
                     $rates += $value;
                        $rates_json[] = [
                            'rating' => $value,
                            'id' => $key
                        ];
               }
            }
            $indicator->rating = $rates / count($request->get('rating'));
            $indicator->rates = $rates_json;
            $indicator->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Indicator Updated successfully.'), $indicator);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $indicator = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$indicator) {
            return $this->responseWithError(_trans('message.Indicator not found'), 'id', 404);
        }
        try {
            $indicator->delete();
            return $this->responseWithSuccess(_trans('message.Indicator Delete successfully.'), $indicator);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
