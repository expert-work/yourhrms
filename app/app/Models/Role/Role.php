<?php

namespace App\Models\Role;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Traits\CompanyTrait;
use App\Models\Hrm\Leave\AssignLeave;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hrm\Attendance\DutySchedule;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Role extends Model
{
    use HasFactory, StatusRelationTrait, LogsActivity,CompanyTrait;

    protected $fillable = ['name', 'slug', 'permissions', 'status_id', 'company_id'];

    protected static $logAttributes = [
        'company_id', 'name', 'slug', 'permissions', 'status_id'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];
   
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    //boot function
    protected static function boot()
    {
        parent::boot();

        static::created(function ($role) {
            Cache::forget('all_roles');
        });
        static::updated(function ($role) {
            Cache::forget('all_roles');
        });
        static::deleted(function ($role) {
            Cache::forget('all_roles');
        });
    }
   
}
