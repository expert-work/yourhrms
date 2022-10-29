<?php

namespace App\Http\Resources\Hrm\Accounts;

use Carbon\Carbon;
use App\Models\Finance\Expense;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseDetailsCollection extends ResourceCollection
{
    public function toArray($expense_info)
    {
    //    $data= Expense::find($request->expense_id);
       return $expense_info;
        return [
            'id' => $data->id,
            'category' => $data->category->name,
            'requested_amount' => currency_format($data->request_amount),
            'approved_amount' => currency_format($data->amount),
            'date_show' => showDate($data->created_at->format('d-m-Y')),
            'date_db' => $data->created_at->format('d-m-Y'),
            'payment' => plain_text($data->payment->name),
            'status' => plain_text($data->status->name),
            'reason' => @$data->remarks,

        ];
    }

    public function with($request)
    {
        return [
            // 'env' => env('FILESYSTEM_DRIVER'),
            'result' => true,
            'message' => "Expense Details",
            'status' => 200
        ];
    }
}
