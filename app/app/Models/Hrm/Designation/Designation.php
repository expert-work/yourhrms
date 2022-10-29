<?php

namespace App\Models\Hrm\Designation;

use App\Models\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Designation extends Model
{
    use HasFactory, StatusRelationTrait, LogsActivity,CompanyTrait;

    protected $fillable = [
        'id', 'company_id','title', 'status_id'
    ];

    protected static $logAttributes = [
       'company_id', 'id','title', 'status_id'
    ];


}
