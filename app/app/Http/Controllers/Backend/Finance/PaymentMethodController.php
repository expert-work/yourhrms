<?php

namespace App\Http\Controllers\Backend\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Hrm\Finance\PaymentMethodsRepository;

class PaymentMethodController extends Controller
{
    protected $PaymentMethodsRepository;
    protected $companyRepository;

    public function __construct(
        PaymentMethodsRepository $PaymentMethodsRepository,
        CompanyRepository $companyRepository
    ) {
        $this->PaymentMethodsRepository = $PaymentMethodsRepository;
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $data['create']     = route('hrm.payment_method.create');
        $data['title']      = _trans('account.Payment Methods');
        $data['fields']     = $this->PaymentMethodsRepository->fields();
        $data['url']        = route('hrm.payment_method.datatable');
        $data['url_id']     = 'payment_methods_datatable_url';
        $data['class']      = 'payment_methods_datatable_class';
        // dd($data);

        return view('backend.finance.payment_methods.index', compact('data'));
    }

    public function datatable()
    {
        return $this->PaymentMethodsRepository->datatable();
    }

    public function create()
    {
        $data['title'] = _trans('account.Add Payment Method');
        $data['list_url'] = route('hrm.payment_method.index');
        $data['url'] = route('hrm.payment_method.store');
        return view('backend.finance.payment_methods.create', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'status_id' => 'required|max:11',
        ]);
        try {
            $request->request->add(['company_id' =>  $this->companyRepository->company()->id]);
            $result = $this->PaymentMethodsRepository->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payment_method.index');
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


    public function edit($id)
    {
        $data['edit'] = $this->PaymentMethodsRepository->edit($id);
        $data['title'] = _trans('account.Edit Payment Method');
        $data['list_url'] = route('hrm.payment_method.index');
        $data['url'] = route('hrm.payment_method.update', $id);
        return view('backend.finance.payment_methods.create', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'status_id' => 'required|max:11',
        ]);
        try {
            $result = $this->PaymentMethodsRepository->update($request, $id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payment_method.index');
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

    public function delete($id)
    {
        try {
            $result = $this->PaymentMethodsRepository->destroy($id, $this->companyRepository->company()->id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payment_method.index');
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
}
