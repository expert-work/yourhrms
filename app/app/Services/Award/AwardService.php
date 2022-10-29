<?php

namespace App\Services\Award;

use App\Models\User;
use App\Models\Award\Award;
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

class AwardService extends BaseService
{
    use RelationshipTrait, DateHandler, FileHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(Award $award)
    {
        $this->model = $award;
    }

    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Employee'),
            _trans('award.Award Type'),
            _trans('award.Gift'),
            _trans('common.Amount'),
            _trans('project.Date'),
            _trans('common.Action')

        ];
    }
    function userDatatable($request,$user_id)
    {
        $award =  $this->model->with('user','status','type')->where(['company_id' => auth()->user()->company_id]);
        
        $award = $award->where('user_id', $user_id)->paginate($request->limit ?? 10);

        return $this->generateDatatable($award);
    }

    function table($request)
    {
        $award =  $this->model->with('user','status','type')->where(['company_id' => auth()->user()->company_id]);
        if (!is_Admin()) {
            $award = $award->whereHas('user', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        }
        $award = $award->paginate($request->limit ?? 10);

        return $this->generateDatatable($award);
        
    }
    function generateDatatable($award)
    {
        return [
            'data' => $award->map(function ($data) {
                $action_button = '';

                if (hasPermission('award_view')) {
                    $action_button .= '<a href="' . route('award.view', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.View') . '</a>';
                }
                
                if (hasPermission('award_edit')) {
                    $action_button .= '<a href="' . route('award.edit', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('award_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/award/delete/`)', 'delete');
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
                    'name' => $data->user->name,
                    'date' => showDate($data->created_at),
                    'type' => $data->type->name,
                    'gift' => $data->gift,
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'amount' => showAmount($data->amount),
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
                'total' => $award->total(),
                'count' => $award->count(),
                'per_page' => $award->perPage(),
                'current_page' => $award->currentPage(),
                'total_pages' => $award->lastPage()
            ],
        ];
    }

    function store($request)
    {
        DB::beginTransaction();
        try {
            $award                           = new $this->model;
            $award->award_type_id            = $request->award_type;
            $award->user_id                  = $request->user_id;
            $award->date                     = $request->date;
            $award->gift                     = $request->gift;
            $award->status_id                = $request->status;
            $award->description              = $request->content;
            $award->amount                   = $request->amount;
            $award->gift_info                = $request->award_info;
            $award->company_id               = auth()->user()->company_id;
            $award->created_by               = auth()->id();
            if ($request->hasFile('attachment')) {
                $award->attachment = $this->uploadImage($request->attachment, 'award/files')->id;
            }
            $award->save();
            DB::commit();

            $user=User::find($award->user_id);
            $title=_trans('response.Award Assigned');
            $notify_body=auth()->user()->name ." "._trans('response.Assigned award ').$award->type->name.' to you';

            SendNotification($user,$title,$notify_body);

            return $this->responseWithSuccess(_trans('message.Award created successfully.'), $award);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    function update($request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $award = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
            if (!$award) {
                return $this->responseWithError(_trans('message.Award not found'), 'id', 404);
            }
            $award->award_type_id            = $request->award_type;
            $award->user_id                  = $request->user_id;
            $award->date                     = $request->date;
            $award->gift                     = $request->gift;
            $award->status_id                = $request->status;
            $award->description              = $request->content;
            $award->amount                   = $request->amount;
            $award->gift_info                = $request->award_info;
            $award->goal_id                  = @$request->goal_id;
            if ($request->hasFile('attachment')) {
                $this->deleteImage(asset_path($award->attachment));
                $award->attachment = $this->uploadImage($request->attachment, 'award/files')->id;
            }
            $award->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Award Updated successfully.'), $award);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $award = $this->model->where(['id' => $id, 'company_id' => auth()->user()->company_id])->first();
        if (!$award) {
            return $this->responseWithError(_trans('message.Award not found'), 'id', 404);
        }
        try {
            if (@$award->attachment) {
                $this->deleteImage(asset_path($award->attachment));
            }
            $award->delete();            
            return $this->responseWithSuccess(_trans('message.Award Delete successfully.'), $award);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}