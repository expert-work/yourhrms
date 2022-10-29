<?php

namespace App\Http\Controllers\Backend\Payroll;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\ProfileRepository;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Hrm\Payroll\CommissionRepository;
use App\Repositories\Hrm\Payroll\PayrollSetUpRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;

class SalarySetUpController extends Controller
{
    protected $view_path = 'backend.payroll.setup';
    protected $payrollSetupRepository;
    protected $companyRepository;
    protected $department;
    protected $profile;
    protected $commissionRepository;

    public function __construct(
        PayrollSetUpRepository $payrollSetupRepository,
        CompanyRepository $companyRepository,
        DepartmentRepository $department,
        ProfileRepository     $profileRepository,
        CommissionRepository $commissionRepository
    ) {
        $this->payrollSetupRepository = $payrollSetupRepository;
        $this->companyRepository = $companyRepository;
        $this->commissionRepository = $commissionRepository;
        $this->department = $department;
        $this->profile = $profileRepository;
    }

    // payroll setup index
    public function index(Request $request)
    {
        try {
            $data['is_permission']  = (hasPermission('store_payroll_item')) ? true : false;
            $data['url']            = (hasPermission('store_payroll_item')) ? route('hrm.payroll_items.store') : '';
            $data['title']          =  _trans('payroll.Employee List');
            $data['departments'] = $this->department->getAll();
            return view($this->view_path . '.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function data(Request $request)
    {
        return $this->payrollSetupRepository->datatable($this->companyRepository->company()->id, $request);
    }

    public function setup($id)
    {
        try {
            $data['title']       = _trans('payroll.Payroll Setup');
            $set_salary          = $this->payrollSetupRepository->getSalaryInfo($id, $this->companyRepository->company()->id);
            if (!$set_salary) {
                Toastr::success($set_salary->original['message'], 'Success');
                return redirect()->back();
            }
            $data['set_salary']  = $set_salary;
            return view($this->view_path . '.salary_set', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function profileSetUp(Request $request, $user_id, $slug)
    {
        $user = User::find($user_id);
        $data['title'] = _trans('common.Salary Setup');
        $data['slug'] = $slug;
        $data['id'] = $user->id;
        $request['user_id'] = $user->id;
        $data['show'] = $this->profile->getProfile($request, $slug);
        return view('backend.user.set_up', compact('data'));
    }

    public function profileSetUpdate(Request $request,$user_id, $slug)
    {
        try { 
            $update= $this->profile->updateProfile($request, $slug);
            if ($update) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->back();
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                return redirect()->back();
            }

        } catch (\Exception $exception) { 
            Toastr::error('Something went wrong.', 'Error');
            return back();
        }
    }

    public function item_list(Request $request)
    {
        $data['title']        = _trans('payroll.Add Commission');
        $data['list']         = $this->commissionRepository->getItemList([
            'company_id' => $this->companyRepository->company()->id,
            'type'    => $request->type
        ]);
        $data['type']         = $request->type;
        $data['user_id']      = $request->user;
        $data['url']          = route('hrm.payroll_setup.store_salary_setup');
        return view('backend.payroll.setup.commission_modal', compact('data'));
    }

    public function store_salary_setup(Request $request)
    {
        $request->validate([
            'type' => 'required:max:191',
            'amount' => 'required:max:191',
        ]);
        $request->merge(['company_id' => $this->companyRepository->company()->id]);
        try {
            $result = $this->payrollSetupRepository->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->back();
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error('Something went wrong', 'Error');
            return redirect()->back();
        }
    }

    public function edit_salary_setup($id)
    {
        $payrollSetupRepository = $this->payrollSetupRepository->salarySetup([
            'company_id' => $this->companyRepository->company()->id,
            'id' => $id
        ]);
        $data['title']          =  _trans('payroll.Update Commission');
        $data['type']         = $payrollSetupRepository->commission->type;
        $data['user_id']      = $payrollSetupRepository->user_id;
        $data['list']         = $this->commissionRepository->getItemList([
            'company_id' => $this->companyRepository->company()->id,
            'type'    => $data['type']
        ]);
        $data['url']          = route('hrm.payroll_setup.update_salary_setup', $id);
        $data['id']           = $id;
        $data['repository']   = $payrollSetupRepository;
        return view('backend.payroll.setup.commission_modal', compact('data'));
    }

    function update_salary_setup(Request $request, $id)
    {
        $request->validate([
            'type' => 'required:max:191',
            'amount' => 'required:max:191'
        ]);
        try {
            $result = $this->payrollSetupRepository->salary_details_update($request, $id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->back();
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error('Something went wrong', 'Error');
            return redirect()->back();
        }
    }
}
