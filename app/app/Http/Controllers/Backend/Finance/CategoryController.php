<?php

namespace App\Http\Controllers\Backend\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Hrm\Finance\DepositCategoryRepository;

class CategoryController extends Controller
{

    protected $DepositCategoryRepository;
    protected $companyRepository;

    public function __construct(
        DepositCategoryRepository $DepositCategoryRepository,
        CompanyRepository $companyRepository
    ) {
        $this->DepositCategoryRepository = $DepositCategoryRepository;
        $this->companyRepository = $companyRepository;
    }

    public function expense()
    {
        $data['create']     = route('hrm.deposit_category.create', 'create=expense');
        $data['title']      = _trans('account.Expense Categories');
        $data['fields']     = $this->DepositCategoryRepository->fields();
        $data['url']        = route('hrm.deposit_category.datatable', 'expense');
        $data['url_id']     = 'deposit_cat_datatable_url';
        $data['class']      = 'deposit_cat_datatable_class';

        return view('backend.finance.category.index', compact('data'));
    }
    public function deposit()
    {
        $data['create']     = route('hrm.deposit_category.create', 'create=deposit');
        $data['title']      = _trans('account.Deposit Categories');
        $data['fields']     = $this->DepositCategoryRepository->fields();
        $data['url']        = route('hrm.deposit_category.datatable', 'deposit');
        $data['url_id']     = 'deposit_cat_datatable_url';
        $data['class']      = 'deposit_cat_datatable_class';
        return view('backend.finance.category.index', compact('data'));
    }

    public function datatable($type)
    {
        if ($type == 'deposit') {
            return $this->DepositCategoryRepository->datatable('deposit');
        } elseif ($type == 'expense') {
            return $this->DepositCategoryRepository->datatable('expense');
        }
    }

    public function create(Request $request)
    {
        $data['url'] = route('hrm.deposit_category.store');
        if (@$request->create == 'deposit') {
            $data['title'] = _trans('account.Add Deposit Category');
            $data['list_url'] = route('hrm.deposit_category.deposit');
            $data['type'] = 1;
        } else {
            $data['title'] = _trans('account.Add Expense Category');
            $data['list_url'] = route('hrm.deposit_category.expense');
            $data['type'] = 0;
        }
        return view('backend.finance.category.create', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'status_id' => 'required|max:11',
        ]);

        try {
            $request->request->add(['company_id' =>  $this->companyRepository->company()->id]);
            $result = $this->DepositCategoryRepository->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                if (@$request->is_income == 1) {
                    $list_url = 'hrm.deposit_category.deposit';
                } else {
                    $list_url = 'hrm.deposit_category.expense';
                }
                return redirect()->route($list_url);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Something went wrong!', 'Error');
            return redirect()->back();
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $data['edit'] = $this->DepositCategoryRepository->model([
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
                'is_income' => @$request->type
            ])->first();
            $data['title'] = _trans('account.Edit Category');
            if (@$request->type == 1) {
                $data['list_url'] = 'hrm.deposit_category.deposit';
                $data['type'] = 1;
            } else {
                $data['list_url'] = 'hrm.deposit_category.expense';
                $data['type'] = 0;
            }
            $data['url'] = route('hrm.deposit_category.update', $id);
            return view('backend.finance.category.create', compact('data'));
        } catch (\Exception $e) {
            Toastr::error('Something went wrong!', 'Error');
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'status_id' => 'required|max:11',
        ]);
        try {
            $result = $this->DepositCategoryRepository->update($request, $id, $this->companyRepository->company()->id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                if (@$request->is_income == 1) {
                    $list_url = 'hrm.deposit_category.deposit';
                } else {
                    $list_url = 'hrm.deposit_category.expense';
                }
                return redirect()->route($list_url);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Toastr::error('Something went wrong!', 'Error');
            return redirect()->back();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $result = $this->DepositCategoryRepository->delete($id, $this->companyRepository->company()->id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                if (@$request->type == 1) {
                    $list_url = 'hrm.deposit_category.deposit';
                } else {
                    $list_url = 'hrm.deposit_category.expense';
                }
                return redirect()->route($list_url);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->route('hrm.accounts.index');
            }
        } catch (\Throwable $th) {
            Toastr::error(_translate('Something went wrong!'), 'Error');
            if (@$request->type == 1) {
                $list_url = 'hrm.deposit_category.deposit';
            } else {
                $list_url = 'hrm.deposit_category.expense';
            }
            return redirect()->route($list_url);
        }
    }
}
