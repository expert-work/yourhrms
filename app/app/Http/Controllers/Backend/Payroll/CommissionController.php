<?php

namespace App\Http\Controllers\Backend\Payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Company\CompanyRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Payroll\CommissionRepository;

class CommissionController extends Controller
{
    use ApiReturnFormatTrait;
    protected $view_path = 'backend.payroll.commission';
    protected $commissionRepository;
    protected $companyRepository;

    public function __construct(CommissionRepository $commissionRepository, CompanyRepository $companyRepository)
    {
        $this->commissionRepository = $commissionRepository;
        $this->companyRepository = $companyRepository;
    }

    public function index(Request $request)
    {
        try {
            $data['is_permission']  = (hasPermission('store_payroll_item')) ? true : false;
            $data['url']            = (hasPermission('store_payroll_item')) ? route('hrm.payroll_items.store') : '';
            $data['title']          =  _trans('payroll.Payroll Item');
            return view($this->view_path . '.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('backend.payroll.commission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191|',
            'type' => 'required:max:191',
            'status' => 'required:max:191',
        ]);

        try {
            $result = $this->commissionRepository->store($request);
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
    public function datatable()
    {
        try {
            return $this->commissionRepository->datatable();
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function edit($id)
    {
        try {
            $data['commission']  = $this->commissionRepository->model([
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ]);
            $data['title']        =  _trans('payroll.Edit Payroll Item');
            $data['url']          = (hasPermission('update_payroll_item')) ? route('hrm.payroll_items.update', [$data['commission']->id, $data['commission']->company_id]) : '';
            $data['is_permission']  = (hasPermission('store_payroll_item')) ? true : false;
            return view($this->view_path . '.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id, $company_id)
    {
        $request->validate([
            'name' => 'required|max:191|',
            'type' => 'required:max:191',
            'status' => 'required:max:191',
        ]);

        try {
            $result = $this->commissionRepository->update($request, $id, $company_id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_items.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error('Something went wrong', 'Error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->commissionRepository->delete($id, $this->companyRepository->company()->id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_items.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                 return redirect()->route('hrm.payroll_items.index');
            }
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
             return redirect()->route('hrm.payroll_items.index');
        }
    }
}
