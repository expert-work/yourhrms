<?php

namespace App\Http\Controllers\Backend\Payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Company\CompanyRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Payroll\AdvanceTypeRepository;

class AdvanceTypeController extends Controller
{
    use ApiReturnFormatTrait;
    protected $view_path = 'backend.payroll.advance_type';
    protected $advanceTypeRepository;
    protected $companyRepository;

    public function __construct(AdvanceTypeRepository $advanceTypeRepository, CompanyRepository $companyRepository)
    {
        $this->advanceTypeRepository = $advanceTypeRepository;
        $this->companyRepository = $companyRepository;
    }

    public function index(Request $request)
    {
        try {
            $data['is_permission']  = (hasPermission('advance_type_store')) ? true : false;
            $data['url']            = (hasPermission('advance_type_store')) ? route('hrm.payroll_advance_type.store') : '';
            $data['title']          =  _trans('payroll.Advance Type');
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
            'status' => 'required:max:191',
        ]);

        try {
            $result = $this->advanceTypeRepository->store($request);
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
            return $this->advanceTypeRepository->datatable();
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function edit($id)
    {
        try {
            $data['commission']  = $this->advanceTypeRepository->model([
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ]);
            $data['title']        =  _trans('payroll.Edit Payroll Item');
            $data['url']          = (hasPermission('advance_type_edit')) ? route('hrm.payroll_advance_type.update', [$data['commission']->id, $data['commission']->company_id]) : '';
            $data['is_permission']  = (hasPermission('advance_type_edit')) ? true : false;
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
            'status' => 'required:max:191',
        ]);

        try {
            $result = $this->advanceTypeRepository->update($request, $id, $company_id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_advance_type.index');
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
            $result = $this->advanceTypeRepository->delete($id, $this->companyRepository->company()->id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_advance_type.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                 return redirect()->route('hrm.payroll_advance_type.index');
            }
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
             return redirect()->route('hrm.payroll_advance_type.index');
        }
    }
}

