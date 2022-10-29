<?php

namespace App\Models\Hrm\Leave;

use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;
use App\Models\Hrm\Department\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class AssignLeave extends Model
{
    use HasFactory, StatusRelationTrait, LogsActivity;

    protected $fillable = [
        'company_id', 'department_id', 'days', 'type_id', 'status_id'
    ];

    protected static $logAttributes = [
        'company_id', 'department_id', 'days', 'type_id', 'status_id'
    ];


    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'type_id');
    }
}
