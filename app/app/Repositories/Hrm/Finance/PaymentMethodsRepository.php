<?php

namespace  App\Repositories\Hrm\Finance;

use Illuminate\Support\Facades\Auth;
use App\Models\Expenses\PaymentMethod;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
//use Your Model

/**
 * Class PaymentMethodsRepository.
 */
class PaymentMethodsRepository
{
    use RelationshipTrait, FileHandler, ApiReturnFormatTrait;
    /**
     * @return string
     *  Return the model
     */

    public function __construct(PaymentMethod $model)
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
            // _trans('account.ID'),
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

    public function datatable()
    {
        $content = $this->model->query()->where('company_id', Auth::user()->company_id);
        // $content = $this->model->query()->where('status_id', 1);
        if (isset($params)) {
            $content = $content->where($params);
        }
        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                if (hasPermission('payment_method_edit')) {
                    $action_button .= '<a href="' . route('hrm.payment_method.edit', $data->id) . '" class="dropdown-item"> Edit</a>';
                }
                if (hasPermission('payment_method_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`hrm/payment-methods/delete/`)', 'delete');
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
            ->addColumn('attachment', function ($data) {
                if (@$data->attachments) {
                    return '<a href="' . uploaded_asset($data->attachment_file_id) . '" target="_blank">' . 'View File' . '</a>';
                    // return @$data->attachments->file_name;
                } else {
                    return '-';
                }
            })
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
        $payment = $this->model([
            'name' => $request->name,
            'company_id' => $request->company_id
        ])->first();
        if ($payment) {
            return $this->responseWithError(_trans('message.Payment method already exists'), 'name', 422);
        }
        try {
            $payment             = new $this->model;
            $payment->company_id = $request->company_id;
            $payment->name       = $request->name;
            $payment->status_id  = $request->status_id;
            $payment->save();
            return $this->responseWithSuccess(_trans('message.Payment method created successfully.'), $payment);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function edit($id)
    {
        return $this->model->query()->find($id);
    }

    public function update($request, $id)
    {

        $payment = $this->model([
            'id' => $id,
            'company_id' => auth()->user()->company_id
        ])->first();
        if (!$payment) {
            return $this->responseWithError(_trans('message.Payment method not found'), 'name', 422);
        }
        try {
            $payment->name       = $request->name;
            $payment->status_id  = $request->status_id;
            $payment->save();
            return $this->responseWithSuccess(_trans('message.Payment method updated successfully.'), $payment);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id, $company_id)
    {
        $payment = $this->model([
            'id' => $id,
            'company_id' => $company_id
        ])->first();
        if (!$payment) {
            return $this->responseWithError(_trans('message.Payment method not found'), 'id', 404);
        }
        try {
            $payment->delete();
            return $this->responseWithSuccess(_trans('message.Payment method delete successfully.'), $payment);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
        $this->model->find($id)->delete();
    }
}
