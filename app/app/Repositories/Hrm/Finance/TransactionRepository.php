<?php

namespace  App\Repositories\Hrm\Finance;

use App\Models\Finance\Account;
use Illuminate\Http\JsonResponse;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\Finance\Transaction;

class TransactionRepository
{

    use ApiReturnFormatTrait;
    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    function fields($transaction = null)
    {
        if ($transaction) {
            return [
                _trans('account.Account'),
                _trans('account.Amount'),
                _trans('account.Type'),
                _trans('account.Date'),
                _trans('account.Status')
            ];
        }
        return [
            _trans('account.Account'),
            _trans('account.Amount'),
            _trans('account.Type'),
            _trans('account.Date'),
            _trans('account.Status'),
            _trans('account.Action'),
        ];
    }


    public function model($filter = null)
    {
        $model = $this->model;
        if ($filter) {
            $model = $this->model->where($filter)->first();
        }
        return $model;
    }

    public function store($request)
    {
        try {
            $transaction                                 = new $this->model;
            $transaction->account_id                     = $request->account;
            $transaction->income_expense_category_id     = $request->category;
            $transaction->date                           = $request->date;
            $transaction->amount                         = $request->amount;
            $transaction->payment_method                 = $request->payment_method;
            $transaction->ref                            = $request->ref;
            $transaction->transaction_type               = 19;
            $transaction->status_id                      = 8;
            $transaction->description                    = $request->description;
            $transaction->company_id                     = auth()->user()->company->id;
            $transaction->created_by                     = auth()->id();
            $transaction->updated_by                     = auth()->id();
            $transaction->save();
            return $this->responseWithSuccess(_trans('message.Deposit created successfully.'), $transaction);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function datatable($request, $transaction = null)
    {
        $params = [];
        $content = $this->model->query()->where('company_id', auth()->user()->company_id);
        if ($request->date) {
            $rawDate = explode(' - ', $request->date);
            $content = $content->whereBetween('created_at', start_end_datetime(date('Y-m-d', strtotime($rawDate[0])), date('Y-m-d', strtotime($rawDate[1]))));
        }
        if ($request->account) {
           $params['account_id'] = $request->account;
        }
        if ($request->transaction_type) {
           $params['transaction_type'] = $request->transaction_type;
        }
        $content = $content->where($params);        
        return datatables()->of($content->latest()->get(),$transaction)
            ->addColumn('action', function ($data) use ($transaction) {
                $action_button = '';
                if ($transaction) {
                  return $action_button;
                }
                if (hasPermission('deposit_edit')) {
                    $action_button .= '<a href="' . route('hrm.deposits.edit', $data->id) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('deposit_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`hrm/deposit/delete/`)', 'delete');
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
            ->addColumn('account', function ($data) {
                return @$data->account->name;
            })
            ->addColumn('category', function ($data) {
                return @$data->category->name;
            })
            ->addColumn('type', function ($data) {
                return '<span class="badge badge-' . @$data->type->class . '">' . @$data->type->name . '</span>';
            })
            ->addColumn('date', function ($data) {
                return @$data->created_at->format('d-m-Y');
            })
            ->addColumn('amount', function ($data) {
                return currency_format(@$data->amount);
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('account', 'type', 'amount', 'date', 'status', 'action'))
            ->make(true);
    }

    public function update($request, $id, $company_id)
    {
        $transaction = $this->model(['id' => $id, 'company_id' => $company_id]);
        if (!$transaction) {
            return $this->responseWithError(_trans('Transaction not found'), 'id', 404);
        }
        try {
            $transaction->account_id                     = $request->account;
            $transaction->income_expense_category_id     = $request->category;
            $transaction->date                           = $request->date;
            $transaction->amount                         = $request->amount;
            $transaction->payment_method                 = $request->payment_method;
            $transaction->ref                            = $request->ref;
            $transaction->description                    = $request->description;
            $transaction->save();
            return $this->responseWithSuccess(_trans('message.Advance type update successfully.'), $transaction);
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
            return $this->responseWithSuccess(_trans('message.Deposit delete successfully.'), $account);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
}
