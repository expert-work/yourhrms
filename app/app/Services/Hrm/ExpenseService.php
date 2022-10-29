<?php

namespace App\Services\Hrm;

use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Expenses\HrmExpense;
use App\Services\Core\BaseService;
use Illuminate\Database\Eloquent\Builder;

class ExpenseService extends BaseService
{
    use RelationshipTrait, DateHandler,CurrencyTrait;

    public function __construct(HrmExpense $hrmExpense)
    {
        $this->model = $hrmExpense;
    }

    public function dataTable()
    {
        $expenses = $this->model->query()
                    ->where('company_id',$this->companyInformation()->id)
            ->select('id','date','user_id','amount','status_id','is_claimed_status_id','attachment_file_id')
            ->where('is_claimed_status_id', 11);

        $expenses->when(\request()->get('date'), function (Builder $builder) {
            $date = explode(' - ', \request()->get('date'));
            return $builder->whereBetween('date', [$this->databaseFormat($date[0]), $this->databaseFormat($date[1])]);
        });
        $expenses->when(\request()->get('user_ids'), function (Builder $builder) {
            return $builder->whereIn('user_id', \request()->get('user_ids'));
        });

        $expenses->when(\request()->get('category_ids'), function (Builder $builder) {
            return $builder->whereIn('income_expense_category_id', \request()->get('category_ids'));
        });
        return datatables()->of($expenses->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $reject = _trans('common.Reject');
                $approve = _trans('common.Approve');
                $delete = _trans('common.Delete');
                if (hasPermission('department_update')) {
                    if ($data->status_id == 1) {
                        $action_button .= actionButton($reject, 'ApproveOrReject(' . $data->id . ',' . "6" . ',`hrm/expense/approve-or-reject/`,`Approve`)', 'approve');
                    }
                    if ($data->status_id == 6) {
                        $action_button .= actionButton($approve, 'ApproveOrReject(' . $data->id . ',' . "1" . ',`hrm/expense/approve-or-reject/`,`Approve`)', 'approve');
                    }
                }
                if (hasPermission('department_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/department/delete/`)', 'delete');
                }
                $button = getActionButtons($action_button);
                return $button;
            })
            ->addColumn('date', function ($data) {
                return @$data->date;
            })
            ->addColumn('file', function ($data) {
                if ($data->attachment_file_id !=null) {
                    return '<a href="' . uploaded_asset($data->attachment_file_id) . '" download class="btn btn-white btn-sm"><i class="fas fa-download"></i></a>';
                }else{
                    return _trans('common.No File');
                }})
            ->addColumn('employee_name', function ($data) {
                return @$data->user->name;
            })
            ->addColumn('amount', function ($data) {
                return $this->getCurrency().$data->amount;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('date', 'employee_name', 'amount', 'status','file', 'action'))
            ->make(true);
    }

    public function approveOrReject($expense, $status)
    {
        $expense->status_id = $status;
        $expense->save();
        return true;
    }

    public function UserExpenseStore($request)
    {
        return $request;
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
