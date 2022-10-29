<?php

namespace App\Models\Expenses;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Company\Company;
use App\Models\coreApp\Status\Status;

class IncomeExpenseCategory extends Model
{
    use HasFactory;

    protected $table = 'income_expense_categories';


    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function attachments():BelongsTo
    {
        return $this->belongsTo(Upload::class,'attachment_file_id','id');
    }

    public function status():BelongsTo
    {
        return $this->belongsTo(Status::class,'status_id','id');
    }
}


