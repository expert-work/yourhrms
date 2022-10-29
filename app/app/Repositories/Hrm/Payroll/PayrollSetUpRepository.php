<?php

namespace  App\Repositories\Hrm\Payroll;

use Validator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Models\Payroll\SalarySetup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Payroll\SalarySetupDetails;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class PayrollSetUpRepository
{
    use ApiReturnFormatTrait;
    protected $model;

    public function __construct(User $model)
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

    public function salarySetup($filter = null)
    {
        $model = SalarySetupDetails::query();
        if ($filter) {
            $model = $model->where($filter)->first();
        }
        return $model;
    }


    public function datatable($company_id, $request)
    {
        $params = [];
        $users = $this->model->query()->with('department','designation','role','shift','status')
                ->where('company_id', $company_id)
                ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'employee_id', 'basic_salary','shift_id', 'status_id','is_hr');

                if (@$request->user_id) {
                    $params['id'] = $request->user_id;
                }
                if (@$request->department_id) {
                    $params['department_id'] = $request->department_id;
                }
        $users->where($params);
        return datatables()->of($users->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                if (hasPermission('view_payroll_set')) {
                    $action_button .= actionButton('Setup', route('hrm.payroll_setup.user_setup', [$data->id, 'contract']), 'Set');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">'.$action_button.'</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('employee', function ($data) {
                return @$data->name;
            })
            ->addColumn('employee_id', function ($data) {
                $id = @$data->employee_id ? @$data->employee_id : '0000' ;
                if (hasPermission('view_payroll_set')) {
                    return '<a class="text-success text-decoration-none text-muted" href="' . route('hrm.payroll_setup.user_setup', [$data->id, 'contract']) . '" class="dropdown-item"> #' . $id . '</a>';
                 }else {
                     return '<span" class="text-success text-decoration-none text-muted"> #' . $id .'</span>';
                 }
            })
            ->addColumn('department', function ($data) {
                return @$data->department->title;
            })
            ->addColumn('designation', function ($data) {
                return @$data->designation->title;
            })
            ->addColumn('role', function ($data) {
                return @$data->role->name;
            })
            ->addColumn('shift', function ($data) {
                return @$data->shift->name;
            })
            ->addColumn('basic_salary', function ($data) {
                return @$data->basic_salary;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('employee', 'employee_id', 'basic_salary', 'department', 'designation', 'role', 'shift', 'status', 'action'))
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

    function getSalaryInfo($id, $company_id)
    {
        $commission = $this->model(['id' => $id, 'company_id' => $company_id]);
        if (!$commission) {
            return $this->responseWithError(_trans('Data not found'), 'id', 404);
        }
        return $commission;
    }

    public function store($request)
    {
        try{

            $user = $this->model->find($request->user_id);
            if (!$user) {
                return $this->responseWithError(_trans('Data not found'), 'id', 404);
            }
            $salary_set_up  = $user->salary_setup;
            if (!$salary_set_up) {
                $salary_set_up                = new SalarySetup;
                $salary_set_up->company_id    =  $user->company_id;
                $salary_set_up->user_id       =  $user->id;
                $salary_set_up->gross_salary  =  $user->basic_salary;
                $salary_set_up->created_by    =   auth()->user()->id;
                $salary_set_up->updated_by    =   auth()->user()->id;
                $salary_set_up->save();
            }
            $set_up_detail = $salary_set_up->salarySetupDetails->where('commission_id', $request->set_up_id)->first();
            if (!$set_up_detail) {
                $set_up_detail                  =  new SalarySetupDetails;
                $set_up_detail->company_id      =  $salary_set_up->company_id;
                $set_up_detail->user_id         =  $user->id;
                $set_up_detail->salary_setup_id =  $salary_set_up->id;
                $set_up_detail->commission_id   =  $request->set_up_id;
                $set_up_detail->amount          =  $request->amount;
                $set_up_detail->amount_type     =  $request->type;
                $set_up_detail->status_id       =  $request->status_id;
                $set_up_detail->created_by      =  auth()->user()->id;
                $set_up_detail->updated_by      =  auth()->user()->id;
                $set_up_detail->save();
            } else {
                return $this->responseWithError(_trans('Data already exists'), 'id', 404);
            }
        return $this->responseWithSuccess(_trans('message.Item created successfully.'), $salary_set_up);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }
    public function salary_details_update($request, $id)
    {
        try{

            $user = $this->model->find($request->user_id);
            if (!$user) {
                return $this->responseWithError(_trans('Data not found'), 'id', 404);
            }
            $salary_set_up  = $user->salary_setup;
            $set_up_detail = $salary_set_up->salarySetupDetails->where('id', $id)->first();
            $old = $salary_set_up->salarySetupDetails->where('commission_id', $request->set_up_id)->first();
            if (!blank(@$old) && @$set_up_detail->id != @$old->id) {
              return $this->responseWithError(_trans('Already added'), 'id', 404);
            }
            $set_up_detail->commission_id   =  $request->set_up_id;
            $set_up_detail->amount          =  $request->amount;
            $set_up_detail->amount_type     =  $request->type;
            $set_up_detail->status_id       =  $request->status_id;
            $set_up_detail->updated_by      =  auth()->user()->id;
            $set_up_detail->save();

        return $this->responseWithSuccess(_trans('message.Item created successfully.'), $salary_set_up);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

}
