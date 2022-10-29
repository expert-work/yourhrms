<?php

namespace  App\Repositories\Hrm\Finance;

use App\Models\Finance\Account;
use Illuminate\Http\JsonResponse;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class AccountRepository
{

    use ApiReturnFormatTrait;
    protected $model;

    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    function fields()
    {
        return [
            _trans('account.Name'),
            _trans('account.Balance'),
            _trans('account.Account Name'),
            _trans('account.Account Number'),
            _trans('account.Branch'),
            _trans('account.Status'),
            _trans('account.Action'),
        ];
    }


    public function model($filter = null)
    {
        $model = $this->model;
        if ($filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function store($request)
    {
        $account = $this->model->where('name', $request->name)->first();
        if ($account) {
            return $this->responseWithError(_trans('Account already exists'), 'name', 422);
        }
        try {
            $account             = new $this->model;
            $account->name       = $request->name;
            $account->amount     = $request->balance;
            $account->ac_name    = $request->ac_name;
            $account->ac_number  = $request->ac_number;
            $account->code       = $request->code;
            $account->branch     = $request->branch;
            $account->status_id  = $request->status;
            $account->company_id = auth()->user()->company->id;
            $account->save();
            return $this->responseWithSuccess(_trans('message.Account created successfully.'), $account);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function datatable()
    {
        $content = $this->model->with('status')->where('company_id', auth()->user()->company_id);
        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                if (hasPermission('account_edit')) {
                    $action_button .= '<a href="' . route('hrm.accounts.edit', $data->id) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('account_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`hrm/accounts/delete/`)', 'delete');
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
            ->addColumn('amount', function ($data) {
                return currency_format(@$data->amount);
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'status', 'action'))
            ->make(true);
    }

    public function update($request, $id, $company_id)
    {
        $account = $this->model(['id' => $id, 'company_id' => $company_id])->first();
        if (!$account) {
            return $this->responseWithError(_trans('Account not found'), 'id', 404);
        }
        try {
            $account->name       = $request->name;
            $account->amount     = $request->balance;
            $account->ac_name    = $request->ac_name;
            $account->ac_number  = $request->ac_number;
            $account->code       = $request->code;
            $account->branch     = $request->branch;
            $account->status_id  = $request->status;
            $account->save();
            return $this->responseWithSuccess(_trans('message.Advance type update successfully.'), $account);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function delete($id, $company_id)
    {
        $account = $this->model(['id' => $id, 'company_id' => $company_id]);
        if (!$account) {
            return $this->responseWithError(_trans('Data not found'), 'id', 404);
        }
        try {
            $account->delete();
            return $this->responseWithSuccess(_trans('message.Advance type delete successfully.'), $account);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
}
