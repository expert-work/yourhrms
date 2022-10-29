<?php

namespace  App\Repositories\Hrm\Payroll;

use Illuminate\Http\JsonResponse;
use Validator;
use App\Models\Payroll\Commission;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class CommissionRepository
{
    use ApiReturnFormatTrait;
    protected $model;

    public function __construct(Commission $model)
    {
        $this->model = $model;
    }

    public function model($filter = null)
    {
        $model = $this->model;
        if ($filter) {
            $model = $this->model->where($filter)->first();
        }
        return $model;
    }

    public function filter()
    {
        $items = $this->model->query()
            ->with('createdBy', 'updatedBy');
        $items = $this->FilterWhenQuery($items);
        if (\request()->get('published_filtering') === '1') {
            $items = $items->where('status_id', 1);
        } elseif (\request()->get('published_filtering') === '0') {
            $items = $items->where('status_id', 4);
        } else {
            return $items;
        }
        return $items;
    }

    public function FilterWhenQuery($query)
    {
        return $query->when(\request()->get('search'), function (Builder $builder) {
            $builder->where('name', 'like', '%' . \request()->get('search') . '%');
        })
            ->when(\request()->get('sort_by'), function (Builder $builder) {
                $builder->orderBy(\request()->get('sort_by'), 'ASC');
            })
            ->when(\request()->get('createdAtStart'), function (Builder $builder) {
                $builder->whereBetween('created_at', [\request()->get('createdAtStart'), \request()->get('createdAtEnd')]);
            });
    }

    public function index(): JsonResponse
    {
        $brands = $this->filter();
        $redirect_page = \request()->get('page') == "" ? "1" : \request()->get('page');

        if (\request()->get('per_page') != null) {
            $pagination_number = \request()->get('per_page') == "all" ? $brands->count() : \request()->get('per_page');
            $brands = $brands->paginate($pagination_number, ['*'], 'page', $redirect_page);
        } else {
            $brands = $brands->paginate(10, ['*'], 'page', $redirect_page);
        }

        $data = [];
        $data['brands'] = $brands;
        $data['maxId'] = $this->model->query()->max('top');
        return $this->responseWithSuccess('Brands list view', $data);
    }



    public function store($request)
    {
        $commission = $this->model->where('name', $request->name)->where('company_id' , auth()->user()->company_id)->first();
        if ($commission) {
            return $this->responseWithError(_trans('Data already exists'), 'name', 422);
        }
        try {
            $commission = new $this->model;
            $commission->name = $request->name;
            $commission->type = $request->type;
            $commission->company_id = auth()->user()->company->id;
            $commission->save();
            return $this->responseWithSuccess(_trans('message.Item created successfully.'), $commission);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function datatable()
    {
        $content = $this->model->query()->where('company_id', auth()->user()->company_id);
        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $row_data = [];
                $row_data['id'] = $data->id;
                $row_data['name'] = $data->name;
                $row_data['type'] = $data->type;
                $row_data['status_id'] = $data->status_id;
                if (hasPermission('edit_payroll_item')) {
                      $action_button .= '<a href="' . route('hrm.payroll_items.edit', $data->id) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }

                if (hasPermission('delete_payroll_item')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`hrm/payroll/item/delete/`)', 'delete');
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
            ->addColumn('name', function ($data) {
                return @$data->name;
            })
            ->addColumn('type', function ($data) {
                if ($data->type == 1) {
                    return '<span class="badge badge-success">'._trans('payroll.Addition').'</span>';
                } else {
                    return '<span class="badge badge-danger">'. _trans('payroll.Deduction') .'</span>';
                }
                return @$data->type;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'type', 'status', 'action'))
            ->make(true);
    }

    public function update($request, $id, $company_id)
    {
        $commission = $this->model(['id' => $id, 'company_id' => $company_id]);
        if (!$commission) {
            return $this->responseWithError(_trans('Data not found'), 'id', 404);
        }
        try {
            $commission->name = $request->name;
            $commission->type = $request->type;
            $commission->status_id = $request->status;
            $commission->save();
            return $this->responseWithSuccess(_trans('message.Item Update successfully.'), $commission);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function delete($id, $company_id)
    {
        $commission = $this->model(['id' => $id, 'company_id' => $company_id]);
        if (!$commission) {
            return $this->responseWithError(_trans('Data not found'), 'id', 404);
        }
        try {
            $commission->delete();
            return $this->responseWithSuccess(_trans('message.Item Delete successfully.'), $commission);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function getItemList($where = []){
        return  $this->model->query()->where($where)->get();
    }
}
