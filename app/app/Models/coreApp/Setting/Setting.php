<?php

namespace App\Models\coreApp\Setting;

use App\Models\coreApp\BaseModel;
use App\Models\Traits\CompanyTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Setting extends Model
{
    use LogsActivity,
    CompanyTrait;

    protected $fillable = ['name', 'value', 'context','company_id'];

    protected static $logAttributes = [
        'company_id','name', 'value','context'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model)  {
            $model->company_id=Auth::check() ? auth()->user()->company->id : 1;
        });
    }

}
