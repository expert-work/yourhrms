<?php

namespace App\Models\coreApp\Setting;

use App\Models\Traits\CompanyTrait;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class IpSetup extends Model
{
    use HasFactory,CompanyTrait,StatusRelationTrait;

    protected $fillable = [
        'location',
        'ip_address',
        'status_id',
        'company_id',
    ];

    public function IsOffice(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'is_office', 'id');
    }
}
