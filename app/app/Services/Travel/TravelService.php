<?php

namespace App\Services\Travel;

use App\Models\Travel\Travel;
use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class TravelService extends BaseService
{
    use RelationshipTrait, DateHandler, FileHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(Travel $travel)
    {
        $this->model = $travel;
    }

    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Employee'),
            _trans('travel.Type'),
            _trans('travel.Place'),
            _trans('travel.Status'),
            _trans('common.Amount'),
            _trans('project.Date'),
            _trans('common.Action')

        ];
    }


    function userDatatable($request,$user_id)
    {
        $travel =  $this->model->with('user','status','type')->where(['company_id' => auth()->user()->company_id]);
        
        $travel = $travel->where('user_id', $user_id)->paginate($request->limit ?? 10);
        
        return $this->generateDatatable($travel);
       
    }
    function table($request)
    {
        $travel =  $this->model->with('user','status','type')->where(['company_id' => auth()->user()->company_id]);
        if (!is_Admin()) {
            $travel = $travel->whereHas('user', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        }
        $travel = $travel->paginate($request->limit ?? 10);

        return $this->generateDatatable($travel);
       
    }

    function generateDatatable($travel)
    {
         return [
            'data' => $travel->map(function ($data) {
                $action_button = '';
                if (hasPermission('travel_view')) {
                    $action_button .= '<a href="' . route('travel.view', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.View') . '</a>';
                }
                if (hasPermission('travel_edit')) {
                    $action_button .= '<a href="' . route('travel.edit', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('travel_approve')) {
                    $action_button .= actionButton( _trans('common.Approve'), 'mainModalOpen(`' . route('travel.approve', $data->id) . '`)', 'modal');
                }
                if (hasPermission('travel_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/travel/delete/`)', 'delete');
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
                    'name' => '<span class="text-muted">' . $data->user->name . '</span>',
                    'date' => '<span class="text-muted">' ._trans('common.Start Date') . ' : ' . showDate($data->start_date) . '</span>' . ' <br> ' . '<span class="text-muted">' ._trans('common.End Date') . ' : ' . showDate($data->end_date) . '</span>',
                    'type' => $data->type->name,
                    'place' => $data->place,
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'amount' => '<span class="text-muted">' ._trans('travel.Expect Amount') . ' : ' . showAmount($data->expect_amount) . '</span>'. '<br>'. '<span class="text-muted">' ._trans('travel.Actual Amount') . ' : ' . showAmount($data->amount) . '</span>',
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
                'total' => $travel->total(),
                'count' => $travel->count(),
                'per_page' => $travel->perPage(),
                'current_page' => $travel->currentPage(),
                'total_pages' => $travel->lastPage()
            ],
        ];
    }

    function store($request)
    {
        DB::beginTransaction();
        try {
            $travel                           = new $this->model;
            $travel->user_id                  = $request->user_id;
            $travel->travel_type_id           = $request->travel_type;
            $travel->purpose                  = $request->motive;
            $travel->place                    = $request->place;
            $travel->start_date               = $request->start_date;
            $travel->end_date                 = $request->end_date;
            $travel->mode                     = $request->mode;
            $travel->expect_amount            = $request->expect_amount;
            $travel->description              = $request->content;
            $travel->amount                   = $request->actual_amount;
            $travel->company_id               = auth()->user()->company_id;
            $travel->created_by               = auth()->id();
            if ($request->hasFile('attachment')) {
                $travel->attachment = $this->uploadImage($request->attachment, 'travel/files')->id;
            }
            $travel->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Travel created successfully.'), $travel);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    function update($request,$id)
    {
        DB::beginTransaction();
        try {
            $travel                           = $this->model->find($id);
            $travel->user_id                  = $request->user_id;
            $travel->travel_type_id           = $request->travel_type;
            $travel->purpose                  = $request->motive;
            $travel->place                    = $request->place;
            $travel->start_date               = $request->start_date;
            $travel->end_date                 = $request->end_date;
            $travel->mode                     = $request->mode;
            $travel->expect_amount            = $request->expect_amount;
            $travel->description              = $request->content;
            $travel->amount                   = $request->actual_amount;
            $travel->goal_id                  = @$request->goal_id;
            if ($request->hasFile('attachment')) {
                $this->deleteImage(asset_path($travel->attachment));
                $travel->attachment = $this->uploadImage($request->attachment, 'travel/files')->id;
            }
            $travel->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Travel Updated successfully.'), $travel);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    function delete($id)
    {
        $travel = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$travel) {
            return $this->responseWithError(_trans('message.Travel not found'), 'id', 404);
        }
        try {
            if (@$travel->attachment) {
                $this->deleteImage(asset_path($travel->attachment));
            }
            $travel->delete();
            return $this->responseWithSuccess(_trans('message.Travel Delete successfully.'), $travel);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    function approve($request, $id)
    {
        $travel = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$travel) {
            return $this->responseWithError(_trans('message.Travel not found'), 'id', 404);
        }
        try {
            $travel->status_id = $request->status;
            $travel->save();
            return $this->responseWithSuccess(_trans('message.Travel Approved successfully.'), $travel);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}