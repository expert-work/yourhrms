<?php

namespace  App\Repositories\Hrm\Finance;

use Illuminate\Support\Facades\Auth;
use App\Helpers\CoreApp\Traits\FileHandler;
use BeyondCode\QueryDetector\Outputs\Console;
use App\Models\Expenses\IncomeExpenseCategory;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class DepositCategoryRepository.
 */
class DepositCategoryRepository
{
    use RelationshipTrait, FileHandler, ApiReturnFormatTrait;

    /**
     * @return string
     *  Return the model
     */

    public function __construct(IncomeExpenseCategory $model)
    {
        $this->model = $model;
    }

    public function model($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    function fields()
    {
        return [
            _trans('account.ID'),
            // _trans('account.Company'),
            _trans('account.Name'),
            // _trans('account.Attachment'),
            _trans('account.Status'),
            _trans('account.Action'),
        ];
    }


    // public function index()
    // {
    //     return $this->model->query()->where('is_income', 1)->get();
    // }

    public function datatable($type)
    {
        if ($type == 'deposit') {
            $content = $this->model->query()->where('is_income', 1)->where('company_id', Auth::user()->company_id);
        } elseif ($type == 'expense') {
            $content = $this->model->query()->where('is_income', 0)->where('company_id', Auth::user()->company_id);
        }
        if (isset($params)) {
            $content = $content->where($params);
        }
        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                if (hasPermission('deposit_category_update')) {
                    $action_button .= '<a href="' . route('hrm.deposit_category.edit', $data->id . '?type=' . $data->is_income) . '" class="dropdown-item"> Edit</a>';
                }
                if (hasPermission('deposit_category_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(`' . $data->id . '?type=' . $data->is_income . '`,`hrm/account-settings/delete/`)', 'delete');
                }
                $button = getActionButtons($action_button);
                return $button;
            })
            // ->addColumn('company', function ($data) {
            //     return @$data->company->name;
            // })
            ->addColumn('name', function ($data) {
                return @$data->name;
            })
            // ->addColumn('attachment', function ($data) {
            //     if (@$data->attachments) {
            //         return '<a href="' . uploaded_asset($data->attachment_file_id) . '" target="_blank">' . 'View File' . '</a>';
            //         // return @$data->attachments->file_name;
            //     } else {
            //         return '-';
            //     }
            // })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            // ->addColumn('date', function ($data) {
            //     return @$data->created_at->format('d-m-Y');
            // })
            ->rawColumns(array('name', 'status', 'action'))
            ->make(true);
    }

    public function store($request)
    {
        $category = $this->model([
            'name' => $request->name,
            'company_id' => $request->company_id,
            'is_income' => intval($request->is_income),
        ])->first();
        if ($category) {
            return $this->responseWithError(_trans('message.Category already exists'), 'name', 422);
        }
        try {
            $category             = new $this->model;
            $category->company_id = $request->company_id;
            $category->name       = $request->name;
            $category->is_income  = $request->is_income;
            $category->status_id  = $request->status_id;
            $category->save();
            return $this->responseWithSuccess(_trans('message.Category created successfully.'), $category);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
    public function update($request, $id, $company_id)
    {
        $category = $this->model([
            'id' => $id,
            'company_id' => $company_id
        ])->first();
        if (!$category) {
            return $this->responseWithError(_trans('message.Category not found'), 'id', 404);
        }
        try {
            $category->name       = $request->name;
            $category->is_income  = $request->is_income;
            $category->status_id  = $request->status_id;
            $category->save();
            return $this->responseWithSuccess(_trans('message.Category created successfully.'), $category);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function delete($id, $company_id)
    {
        $category = $this->model([
            'id' => $id,
            'company_id' => $company_id
        ])->first();
        if (!$category) {
            return $this->responseWithError(_trans('message.Category not found'), 'id', 404);
        }

        try {
            $category->delete();
            return $this->responseWithSuccess(_trans('message.Category delete successfully.'), $category);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
}
