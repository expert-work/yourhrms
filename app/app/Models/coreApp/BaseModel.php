<?php

namespace App\Models\coreApp;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BaseModel extends Model
{
    use LogsActivity;
}
